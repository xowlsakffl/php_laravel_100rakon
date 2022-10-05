<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('oidx');
            $table->unsignedBigInteger('odx');
            $table->unsignedBigInteger('pdx');
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('quantity')->default(0);
            $table->unsignedBigInteger('amount')->default(0);
            $table->unsignedSmallInteger('delivery_origin_cost')->default(0);
            $table->string('delivery_kind', 10)->default("무료");
            $table->unsignedSmallInteger('delivery_pay')->default(0);
            $table->string('delivery_logistics', 30)->default("");
            $table->string('delivery_serial', 20)->default("");
            $table->unsignedTinyInteger('state')->default(10);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('odx')->references('odx')->on('orders')->onDelete('cascade');
            $table->foreign('pdx')->references('pdx')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
