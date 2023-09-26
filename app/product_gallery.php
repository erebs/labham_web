<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_gallery extends Model
{
    use HasFactory;
    protected $table='product_galleries';
    protected $guarded=[];
}
