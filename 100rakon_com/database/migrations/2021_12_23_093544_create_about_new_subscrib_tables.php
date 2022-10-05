<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutNewSubscribTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Files
        Schema::table('files', function (Blueprint $table) {
            $table->unsignedBigInteger('sgdx')->nullable()->default(null);
            $table->foreign('sgdx')->references('sgdx')->on('subscrib_goods');
        });

        // Subscrib Good Product
        Schema::table('subscrib_good_products', function (Blueprint $table) {
            $table->integer('delivery_per_month')->default(2);
            $table->string('is_basic', 1)->default("N");
            $table->integer('unit_price_normal')->default(0);
            $table->integer('unit_price_half')->default(0);
            $table->integer('unit_price_year')->default(0);
        });

        // Subscrib Orders
        Schema::table('subscrib_orders', function (Blueprint $table) {
            $table->string('pay_term', 20)->default("일시불");
            $table->integer('pay_total_times')->default(1);
            $table->string('pay_day', 2)->default("15");
        });

        //테이블 만들기
        // Subscrib Order Items
        Schema::create('subscrib_order_items', function (Blueprint $table) {
            $table->bigIncrements('soidx');
            $table->unsignedBigInteger('sodx');
            $table->unsignedBigInteger('sgpdx');
            $table->unsignedBigInteger('price')->default(0);
            $table->integer('quantity')->default(0);
            $table->unsignedBigInteger('amount')->default(0);
            $table->unsignedTinyInteger('state')->default(10);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sodx')->references('sodx')->on('subscrib_orders')->onDelete('cascade');
            $table->foreign('sgpdx')->references('sgpdx')->on('subscrib_good_products');
        });

        // Subscrib Order History
        Schema::create('subscrib_order_histories', function (Blueprint $table) {
            $table->bigIncrements('idx');
            $table->unsignedBigInteger('sodx');
            $table->string('kind', 20)->default("기타");
            $table->text('content')->default("");
            $table->timestamps();

            $table->foreign('sodx')->references('sodx')->on('subscrib_orders')->onDelete('cascade');
        });

        // Order History
        Schema::create('order_histories', function (Blueprint $table) {
            $table->bigIncrements('idx');
            $table->unsignedBigInteger('odx');
            $table->string('kind', 20)->default("기타");
            $table->text('content')->default("");
            $table->timestamps();

            $table->foreign('odx')->references('odx')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Files
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn('sgdx');
        });

        // Subscrib Good Product
        Schema::table('subscrib_good_products', function (Blueprint $table) {
            $table->dropColumn('delivery_per_month');
            $table->dropColumn('is_basic');
            $table->dropColumn('unit_price_normal');
            $table->dropColumn('unit_price_half');
            $table->dropColumn('unit_price_year');
        });

        // Subscrib Orders
        Schema::table('subscrib_orders', function (Blueprint $table) {
            $table->dropColumn('pay_term');
            $table->dropColumn('pay_total_times');
            $table->dropColumn('pay_day');
        });

        // REMOVE TABLES
        Schema::dropIfExists('order_histories');
        Schema::dropIfExists('subscrib_order_histories');
        Schema::dropIfExists('subscrib_order_items');
    }
}
