<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->increments('id');
      $table->enum('type', ['superadmin', 'admin','user'])->default('user');
      $table->string('name', 64)->default('');
      $table->string('email', 128)->default('');
      $table->string('password', 256)->default('');
      $table->string('phone', 13)->default('');
      $table->integer('added_by')->default(0);
      $table->enum('status', ['Active', 'Pending', 'Suspended', 'Deleted'])->default('Pending');
      $table->rememberToken();
      $table->timestamps();
  });

  DB::table('users')->insert([
    'type' => 'superadmin',
    'name' => 'SuperAdmin',
    'email' => 'superadmin@gmail.com',
    'password' => md5('SuperAdmin@FhDBZR#1199'),
    'phone' => '',
    'added_by' => '0',
    'status' => 'Active',
    'created_at' => date('Y-m-d H:i:00'),
    'updated_at' => date('Y-m-d H:i:00'),
  ]);
}

  public function down()
  {
    Schema::dropIfExists('users');
  }
}
