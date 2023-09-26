<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customers extends Authenticatable
{
  use HasApiTokens;
  public $timestamps = false;
  protected $guarded=[];
}
