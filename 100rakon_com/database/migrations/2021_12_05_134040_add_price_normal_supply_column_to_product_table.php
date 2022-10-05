<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceNormalSupplyColumnToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->integer('price_normal')->default(0);
            $table->integer('delivery_origin_cost')->default(0);
            $table->string('supply', 150)->default('제조사');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->dropColumn('price_normal');
            $table->dropColumn('delivery_origin_cost');
            $table->dropColumn('supply');
        });
    }
}
