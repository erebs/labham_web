<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cat_id')->default(0);
            $table->integer('subcat_id')->default(0);
            $table->integer('brand_id')->default(0);
            $table->integer('stock_avalible')->default(1);
            $table->string('name', 64)->default('');
            $table->string('desc', 1024)->default('');
            $table->float('price')->default(0);
            $table->float('offerprice')->default(0);
            $table->enum('best_seller', ['0', '1'])->default('0');
            $table->enum('featured', ['0', '1'])->default('0');
            $table->enum('trending', ['0', '1'])->default('0');
            $table->enum('status', ['Available', 'Not Available'])->default('Not Available');
            $table->string('image', 128)->default('');
            $table->string('image2', 128)->default('');
            $table->string('image3', 128)->default('');
            $table->string('image4', 128)->default('');
            $table->string('delstatus',20)->default('Active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
