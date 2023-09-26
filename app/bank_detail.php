<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bank_detail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='bank_details';
    protected $guarded=[];
}
