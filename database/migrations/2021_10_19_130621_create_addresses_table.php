<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->enum('default', [0, 1])->default(0);
            $table->string('name', 64)->default('');
            $table->string('email', 64)->default('');
            $table->string('mobile', 13)->default('');
            $table->string('phone', 13)->default('');
            $table->string('pincode', 10)->default('');
            $table->string('landmark', 64)->default('');
            $table->string('city', 64)->default('');
            $table->string('address', 512)->default('');
            $table->string('district', 64)->default('');
            $table->string('state', 64)->default('');
            $table->enum('type', ['Work', 'Home'])->default('Home');
            $table->enum('status', ['Active', 'Deleted'])->default('Active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
