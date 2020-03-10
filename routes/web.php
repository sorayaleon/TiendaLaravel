<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    
    Route::resource('users', 'UsersController')->middleware('perfil:admin', 'auth');
    Route::get('users-pdf', 'UsersController@pdfAll')->name('users.pdfAll')->middleware('perfil:admin','auth');
    Route::get('users-pdf/{id}', 'UsersController@pdf')->name('users.pdf')->middleware('perfil:admin','auth');

    Route::resource('productos', 'ProductosController')->middleware('perfil:admin','auth');
    Route::get('productos-pdf', 'ProductosController@pdfAll')->name('productos.pdfAll')->middleware('perfil:admin','auth');
    Route::get('producto-pdf/{id}', 'ProductosController@pdf')->name('producto.pdf')->middleware('perfil:admin','auth');

    Route::resource('ventas', 'VentasController')->middleware('perfil:admin', 'auth');
    Route::get('ventas-pdf', 'VentasController@pdfAll')->name('ventas.pdfAll')->middleware('perfil:admin','auth');
    Route::get('ventas-pdf/{id}', 'VentasController@pdf')->name('ventas.pdf')->middleware('perfil:admin','auth');

});


Route::prefix('catalogo')->group(function () {

    Route::get('/', 'CatalogoController@index')->name('catalogo.index');
    Route::get('producto/{id}', 'CatalogoController@show')->name('catalogo.show');
});

Auth::routes();
Route::prefix('home')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::put('actualizar/{id}', 'HomeController@update')->name('home.update');
    Route::get('compras/{id}', 'HomeController@show')->name('home.compra')->middleware('auth');
    Route::get('compras-pdf/{id}', 'HomeController@pdf')->name('home.pdf')->middleware('auth');
});

Route::prefix('contacto')->group(function () {
    Route::get('/', 'CorreosController@index')->name('contacto');
    Route::post('enviar', 'CorreosController@enviar')->name('contacto.enviar');;
});

Route::prefix('carrito')->group(function () {
    Route::get('/', 'CarritoController@index')->name('carrito.index');
    Route::get('insertar/{id}', 'CarritoController@insertar')->name('carrito.insertar');
    Route::delete('eliminar/{id}', 'CarritoController@eliminar')->name('carrito.eliminar');
    Route::post('actualizar', 'CarritoController@actualizar')->name('carrito.actualizar');
    Route::get('vaciar', 'CarritoController@vaciar')->name('carrito.vaciar');
    Route::get('venta', 'CarritoController@venta')->name('carrito.venta')->middleware('auth');
    Route::post('salvar', 'CarritoController@salvar')->name('carrito.salvar')->middleware('auth');
    Route::get('factura/{id}', 'CarritoController@factura')->name('carrito.factura')->middleware('auth');
    Route::get('descargar/{id}', 'CarritoController@descargar')->name('carrito.descargar')->middleware('auth');
});
