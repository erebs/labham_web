<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
  public $timestamps = false;
   protected $guarded=[];

   public function GetProd()
    {
        return $this->belongsTo(Products::class, 'productid', 'id');
    }
}
