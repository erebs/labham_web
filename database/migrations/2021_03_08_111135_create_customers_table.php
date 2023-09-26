<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64)->default('');
            $table->string('email', 64)->default('');
            $table->string('phone', 13)->default('');
            $table->string('password', 64)->default('');
            $table->string('address', 1024)->default('');
            $table->string('pincode', 10)->default('');
            $table->string('area', 64)->default('');
            $table->string('district', 64)->default('');
            $table->string('state', 64)->default('');
            $table->string('latitude', 64)->default('');
            $table->string('longitude', 64)->default('');
            $table->dateTime('join_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
