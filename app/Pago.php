<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table= "pagos";
    protected $fillable = [
        'titular', 'tipo', 'numero', 'cvv', 'mes', 'año', 'venta_id'
    ];
   
    public function venta()
    {
        return $this->belongsTo('App\Venta');
    }
}
