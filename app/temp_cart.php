<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class temp_cart extends Model
{
    use HasFactory;
public $timestamps = false;
    protected $table='temp_carts';
    protected $guarded=[];

    public function GetProd()
    {
        return $this->belongsTo(Products::class, 'productid', 'id');
    }
}
