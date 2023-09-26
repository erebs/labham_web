<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class return_image extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='return_images';
    protected $guarded=[];
}
