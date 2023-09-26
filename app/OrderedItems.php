<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderedItems extends Model
{
  public $timestamps = false;
  protected $guarded=[];

  public function GetProd()
    {
        return $this->belongsTo(Products::class, 'productid', 'id');
    }

    public function order()
{
    return $this->belongsTo(Order::class, 'orderid');
}
public function product()
{
    return $this->belongsTo(Products::class, 'productid');
}
}
