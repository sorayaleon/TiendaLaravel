<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Venta extends Model
{
    protected $table= "ventas";
    protected $fillable = [
        'codigo', 'fecha','total', 'subtotal', 'iva', 'user_id'
    ];

    public function usuario()
    {
        return $this->belongsTo('App\User');
    }

    public function pago()
    {
        return $this->hasOne('App\Pago');
    }

    public function venta()
    {
        return $this->hasOne('App\Envio');
    }

    public function lineas()
    {
        return $this->hasMany('App\LineaVenta');
    }
}
