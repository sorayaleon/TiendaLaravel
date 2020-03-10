<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;


use App\Producto;
class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productos = Producto::search($request->name)->orderBy('id', 'ASC')->paginate(2);
        return view('admin.productos.index')->with('productos', $productos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.productos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'marca'=>'min:4|max:120|required',
            'modelo'=> 'min:4|max:250|required',
            'precio' => 'required|regex:/^\d{1,13}(\.\d{1,2})?$/',
            'stock'=> 'min:1|max:100|required',
            'imagen' => 'required'
        ]);
        try{
            $producto = new Producto($request->all());
            $producto->imagen = $request->file('imagen')->store('storage');
            $producto->save();
            flash('Producto '. $producto->modelo.'  creado con éxito.')->success()->important();
            return redirect()->route('productos.index'); 
        }catch(\Exception $e){
            flash('Error al crear el Producto'. $producto->modelo.'.'.$e->getMessage())->error()->important();
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
        $producto = Producto::find($id);
        return view('admin.productos.show')->with('producto', $producto);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::find($id);
        return view('admin.productos.edit', ['producto'=>$producto]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'marca'=>'min:4|max:120|required',
            'modelo'=> 'min:4|max:250|required',
            'precio' => 'required|regex:/^\d{1,13}(\.\d{1,2})?$/',
            'stock'=> 'min:1|max:100|required',
        ]);
        try{
            $producto = Producto::find($id);
            $producto->marca = $request->marca;
            $producto->modelo = $request->modelo;
            $producto->precio = $request->precio;
            $producto->tipo= $request->tipo;
            $producto->stock =$request->stock;
            if($request->imagen){
                if(Storage::exists($producto->imagen)){
                    Storage::delete($producto->imagen);
                }
                $producto->imagen = $request->file('imagen')->store('storage');
            }
            $producto->save();
            flash('Producto '. $producto->modelo. '  modificado/a con éxito.')->warning()->important();
            return redirect()->route('productos.index');
        }catch(\Exception $e){
            flash('Error al modificar el Producto '. $producto->modelo.'.'.$e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $producto = Producto::find($id);
            if(Storage::exists($producto->imagen)){
                Storage::delete($producto->imagen);
            }
            $producto->delete();
            flash('Producto '. $producto->modelo.'  eliminado/a con éxito.')->error()->important();
            return redirect()->route('productos.index');
        }catch(\Exception $e){
            flash('Error al eliminar Usuario/a '. $producto->modelo.'.'.$e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Crea una vista en PDF con los datos de los productos
     */
    public function pdfAll()
    {
        $productos = Producto::all();
        $pdf = PDF::loadView('pdf.productos', compact('productos'));
        $fichero = 'productos-'.date("YmdHis").'.pdf';
        return $pdf->download($fichero);
    }
    /**
     * Crea una vista en PDF con los datos de un producto
     */
    public function pdf($id)
    {
        $producto = Producto::find($id);
        $pdf = PDF::loadView('pdf.producto', compact('producto'));
        $fichero = 'producto'.date("YmdHis").'.pdf';
        return $pdf->download($fichero);
    }
}
