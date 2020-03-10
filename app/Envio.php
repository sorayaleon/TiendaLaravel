<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    protected $table= "envios";
    protected $fillable = [
        'nombre', 'direccion', 'ciudad', 'provincia', 'codigoPostal',
        'telefono', 'email', 'venta_id'
    ];
  
    public function venta()
    {
        return $this->belongsTo('App\Venta');
    }
}
