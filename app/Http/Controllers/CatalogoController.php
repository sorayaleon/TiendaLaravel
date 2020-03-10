<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Producto;
class CatalogoController extends Controller
{
    /*
     * Devuelve la vista del Catálogo principal, como máximo 6 paginados
    */
    public function index(Request $request)
    {
        $productos = Producto::search($request->name)->orderBy('id', 'ASC')->paginate(6);
        return view('catalogo.index')->with('productos', $productos);
    }

    /**
    * Muestra la ficha de un producto
    */
    public function show($id)
    {
        $producto = Producto::find($id);
        return view('catalogo.show')->with('producto', $producto);
    }
}
