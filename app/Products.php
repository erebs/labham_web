<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
  public $timestamps = false;

  protected $guarded=[];

  public function GetCat()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'id');
    }
}
