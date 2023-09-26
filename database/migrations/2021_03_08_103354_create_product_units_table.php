<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_units', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('productid')->default(0);
            $table->string('name', 64)->default('');
            $table->float('price')->default(0);
            $table->float('offerprice')->default(0);
            $table->smallInteger('disp_order')->default(1);
            $table->enum('status', ['Enabled', 'Disabled'])->default('Enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_units');
    }
}
