<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  public $timestamps = false;
   protected $guarded=[];

   public function orderedItems()
{
    return $this->hasMany(OrderedItems::class, 'orderid');
}
public function returnImages()
{
    return $this->hasMany(return_image::class, 'orderid');
}
}
