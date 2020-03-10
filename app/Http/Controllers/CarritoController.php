<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Cart;
use Auth;
use App\Producto;
use App\Venta;
use App\Pago;
use App\Envio;
use App\LineaVenta;
use Illuminate\Support\Facades\Mail;


class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('carrito.index');
    }


    /**
     * Inserta un elemento en el carrito
     */
    public function insertar($id)
    {
        $producto = Producto::find($id);
        Cart::add($producto,1);
        flash('Producto '. $producto->modelo.'  añadido al carrito.')->success()->important();
        return redirect()->route('carrito.index');
    }

    /**
     * Borrar un elemento del carrito
     */
    public function eliminar($id)
    {
        $nombre = Cart::get($id)->name;
        Cart::remove($id);
        flash('Producto '.$nombre.'  eliminado del carrito.')->error()->important();
        return redirect()->route('carrito.index');
    }

    public function actualizar (Request $request)
    {
        Cart::update($request->id, $request->cantidad);
        flash('Producto '.$request->nombre.'  modificado en el carrito.')->warning()->important();
        return redirect()->route('carrito.index');
    }

    public function vaciar ()
    {
        Cart::destroy();
        flash('Carrito eliminado')->warning()->important();
        return redirect()->route('catalogo.index'); 
    }

    public function venta()
    {
        return view('carrito.venta');
    }

    public function salvar(Request $request)
    {
        $request->validate([
            'tTitular'=>'min:4|max:120|required',
            'nombre'=> 'min:4|max:120|required',
            'direccion'=> 'min:4|max:120|required',
            'ciudad'=> 'min:4|max:120|required',
            'provincia'=> 'min:4|max:120|required',
            'codigoPostal'=> 'min:5|max:5|required',
            'telefono'=> 'min:9|max:15|required',
            'email'=> 'min:4|max:120|required'
        ]);

        try{

            $venta = new Venta();
            $venta->codigo = Auth::user()->id.'-'.time().'-'.strftime("%Y%m%d");
            $venta->fecha =  date('Y-m-d H:i:s');
            $venta->total = round(Cart::subtotal(),2);
            $venta->subtotal = round((Cart::subtotal()/1.21),2);
            $venta->iva = round((Cart::tax()/1.21),2);
            $venta->user_id = Auth::user()->id;
            $venta->save();

            $pago = new Pago();
            $pago->titular = $request->tTitular;
            $pago->tipo = $request->tTipo;
            $pago->numero = substr($request->tNumero,-4);
            $pago->cvv = $request->tCVV;
            $pago->mes = $request->tMes;
            $pago->año = $request->tAño;
            $pago->venta_id = $venta->id;
            $pago->save();

            $envio = new Envio();
            $envio->nombre= $request->nombre;
            $envio->direccion = $request->direccion;
            $envio->ciudad = $request->ciudad;
            $envio->provincia = $request->provincia;
            $envio->codigoPostal = $request->codigoPostal;
            $envio->telefono = $request->telefono;
            $envio->email = $request->email;
            $envio->venta_id = $venta->id;
            $envio->save();

            $lineas=[];
            foreach (Cart::content() as $item){
                $linea = new LineaVenta();
                $linea->venta_id = $venta->id;
                $linea->producto = $item->name;
                $linea->precio = $item->price;
                $linea->cantidad = $item->qty;
                $linea->total = $item->subtotal;
                $linea->producto_id = $item->model->id;
                $linea->save();
                $lineas[]=$linea;
               
                $producto = $item->model;
                $producto->stock-= $linea->cantidad;
                $producto->save();
            }

            Cart::store($venta->codigo);
            Cart::destroy();

            $pdf = PDF::loadView('pdf.factura',
             ['venta'=>$venta,
             'pago'=>$pago,
             'envio'=>$envio,
             'lineas'=>$lineas
             ]);
         
         $pdf->save(storage_path('app/facturas/factura.pdf'));

         $data = ['venta'=>$venta,
                'envio'=>$envio,
                'pago'=>$pago,
                'lineas'=>$lineas
                ];
        
         Mail::send('mails.compra', $data, function ($message) use ($venta, $envio) {
            $message->from('laracrud@tienda.com', 'LaraCRUD-SHOP');
            $message->to($envio->email, 'José Luis');
            $message->subject('Confirmación de compra: '. $venta->codigo);
            $message->attach(storage_path('app/facturas/').'factura.pdf', [
                'as' => 'factura.pdf',
                'mime' => 'application/pdf',
            ]);
        });

        flash('Venta realizada con éxito. Imprima o descargue su factura, luego finalice')->success()->important();
        return redirect()->route('carrito.factura', $venta->codigo);
        }catch(\Exception $e){
            $venta->delete();
            flash('Error al procesar la venta '.$e->getMessage())->error()->important();
            return redirect()->back();
        }
    }


    public function factura($id){
        $venta = Venta::where("codigo",$id)->first();
        if(($venta->user_id==Auth::user()->id)|| Auth::user()->tipo=='admin'){
            $pago = Pago::where("venta_id",$venta->id)->first();
            $envio = Envio::where("venta_id",$venta->id)->first();
            $lineas = LineaVenta::where("venta_id",$venta->id)->get();
            return view('carrito.factura',
                ['venta' => $venta,
                'pago' => $pago,
                'envio' => $envio,
                'lineas' => $lineas
                ]);
        }else{
            return abort(404);
        }
    }

    public function descargar($id){
        $venta = Venta::where("codigo",$id)->first();
        if(($venta->user_id==Auth::user()->id)|| Auth::user()->tipo=='admin'){
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
