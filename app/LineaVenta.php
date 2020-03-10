<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineaVenta extends Model
{
    protected $table= "linea_ventas";
    protected $fillable = [
        'venta_id', 'producto', 'precio', 'cantidad', 'total'
    ];

    public function venta()
    {
        return $this->belongsTo('App\Venta');
    }

    public function producto()
    {
        return $this->belongsTo('App\Producto');
    }
}
