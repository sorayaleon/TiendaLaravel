<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Contracts\Buyable;

class Producto extends Model implements Buyable
{
    protected $table= "productos";
    protected $fillable = [
        'marca', 'modelo', 'precio','tipo', 'stock','imagen'
    ];

    public function scopeSearch($query, $name){
        return $query->where('modelo', 'LIKE', "%$name%" )->orWhere('marca', 'LIKE', "%$name%");
    }

    public function getBuyableIdentifier($options = null) {
        return $this->id;
    }

    public function getBuyableDescription($options = null) {
        return $this->modelo;
    }

    public function getBuyablePrice($options = null) {
        return $this->precio;
    }

    public function lineas()
    {
        return $this->hasMany('App\LineaVenta');
    }
}
