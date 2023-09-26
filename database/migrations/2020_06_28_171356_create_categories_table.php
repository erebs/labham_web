<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{

  public function up()
  {
    Schema::create('categories', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 64)->default('');
      $table->string('image', 128)->default('');
      $table->integer('disporder')->default('1');
      $table->string('status',20)->default('Active');
    });
  }
  
  public function down()
  {
    Schema::dropIfExists('categories');
  }
}
