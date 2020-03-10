<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;
use Auth;
use App\User;
use \Carbon\Carbon;
use App\Venta;
use App\Producto;
use App\Pago;
use App\Envio;
use App\LineaVenta;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $fechaInicio = Carbon::parse('2018-01-11');
        $fechaFin = Carbon::tomorrow();
        if($request->fechaInicio && $request->fechaFin){
            $fechaInicio = $request->fechaInicio;
            $fechaFin = $request->fechaFin;
        }
        
        $compras = Venta::where('user_id', $user_id)
        ->whereBetween('fecha', [$fechaInicio, $fechaFin])
        ->join('users', 'users.id', '=', 'ventas.user_id')
        ->select('ventas.id', 'ventas.codigo', 'ventas.fecha','users.name', 'ventas.total')
        ->orderBy('ventas.fecha', 'desc')
        ->paginate(4);
        return view('/home')->with('compras', $compras);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'min:4|max:120|required',
            'email'=> 'min:4|max:250|required',
        ]);
        try{
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            if($request->imagen){
                if(Storage::exists($user->imagen)){
                    Storage::delete($user->imagen);
                }
                $user->imagen = $request->file('imagen')->store('storage');
            }
            $user->save();
            flash('Usuario/a '. $user->name.'  modificado/a con éxito.')->success()->important();
            return redirect()->route('home');
        }catch(\Exception $e){
            flash('Error al modificar el Usuario/a '. $user->name.'.'.$e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venta = Venta::find($id);
        if(($venta->user_id==Auth::user()->id)){
            $pago = Pago::where("venta_id",$venta->id)->first();
            $envio = Envio::where("venta_id",$venta->id)->first();
            $lineas = LineaVenta::where("venta_id",$venta->id)
            ->join('productos', 'productos.id', '=', 'linea_ventas.producto_id')
            ->select('linea_ventas.producto', 'linea_ventas.precio', 'linea_ventas.cantidad',
            'linea_ventas.total', 'productos.imagen')
            ->get();
            return view('home.compra',
            ['venta' => $venta,
            'pago' => $pago,
            'envio' => $envio,
            'lineas' => $lineas
            ]);
        }else{
            return abort(404);
        }
    }

    public function pdf($id)
    {
        $venta = Venta::find($id);
        if(($venta->user_id==Auth::user()->id)){
            $pago = Pago::where("venta_id",$venta->id)->first();
            $envio = Envio::where("venta_id",$venta->id)->first();
            $lineas = LineaVenta::where("venta_id",$venta->id)->get();
            $pdf = PDF::loadView('pdf.factura',
                ['venta'=>$venta,
                'pago'=>$pago,
                'envio'=>$envio,
                'lineas'=>$lineas
                ]);
            $fichero = 'factura-'.$venta->codigo.'.pdf';
            return $pdf->download($fichero);
        }else{
            return abort(404);
        }
    }

}
