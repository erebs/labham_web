<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customerid')->default(0);
            $table->integer('addressid')->default(0);
            $table->integer('productid')->default(0);
            $table->string('unit_name', 32)->default('');
            $table->float('price')->default(0);
            $table->float('offerprice')->default(0);
            $table->smallInteger('quantity')->default(0);
            $table->enum('paytype', ['CoD', 'Online'])->default('CoD');
            $table->enum('paystatus', ['Success', 'Pending', 'Failed'])->default('Pending');
            $table->enum('status', ['New', 'Accepted', 'Processing', 'Cancelled', 'Delivered', 'Rejected'])->default('New');
            $table->string('details', 512)->default('');
            $table->dateTime('order_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
