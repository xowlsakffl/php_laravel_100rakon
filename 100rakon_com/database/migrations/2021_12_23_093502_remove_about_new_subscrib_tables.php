<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveAboutNewSubscribTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Subscrib Goods
        Schema::table('subscrib_goods', function (Blueprint $table) {
            $table->dropColumn('price_normal');
            $table->dropColumn('price_year');
            $table->dropColumn('price_month');
        });

        // Subscrib Good Products
        Schema::table('subscrib_good_products', function (Blueprint $table) {
            $table->dropColumn('components');
            $table->dropColumn('quantity_per_month');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Subscrib Goods
        Schema::table('subscrib_goods', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('price_normal')->default(0);
            $table->unsignedBigInteger('price_year')->default(0);
            $table->unsignedBigInteger('price_month')->default(0);
        });

        // Subscrib Goods Products
        Schema::table('subscrib_good_products', function (Blueprint $table) {
            $table->string('components', 200)->default("구성");
            $table->integer('quantity_per_month')->default(0);
        });
    }
}
