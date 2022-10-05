<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateOrderBasketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('order_baskets', function (Blueprint $table) {
            $table->bigIncrements('obdx');
            $table->unsignedBigInteger('udx');
            $table->unsignedBigInteger('pdx');
            $table->unsignedBigInteger('quantity')->default(0);
            $table->unsignedTinyInteger('state')->default(10);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('udx')->references('udx')->on('users');
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
        //
        Schema::dropIfExists('order_baskets');
    }
}
