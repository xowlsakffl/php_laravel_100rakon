<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 카테고리 생성
        Schema::create('subscrib_good_categories', function (Blueprint $table) {
            $table->bigIncrements('sgcdx');
            $table->unsignedSmallInteger('sequence')->default(0);
            $table->string('cname', 100)->default("");
            $table->unsignedSmallInteger('parent')->default(0);
            $table->unsignedTinyInteger('state')->default(10);
            $table->timestamps();
            $table->softDeletes();
        });

        // 상품목록 생성
        Schema::create('subscrib_goods', function (Blueprint $table) {
            $table->bigIncrements('sgdx');
            $table->unsignedBigInteger('sgcdx')->nullable();
            $table->unsignedSmallInteger('sequence')->default(0);
            $table->string('title', 150)->default("제목");
            $table->unsignedBigInteger('price_normal')->default(0);
            $table->unsignedBigInteger('price_year')->default(0);
            $table->unsignedBigInteger('price_month')->default(0);
            $table->text('content')->default("");
            $table->unsignedTinyInteger('state')->default(10);
            $table->unsignedBigInteger('hit')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sgcdx')->references('sgcdx')->on('subscrib_good_categories');
        });

        // 제품목록 생성
        Schema::create('subscrib_good_products', function (Blueprint $table) {
            $table->bigIncrements('sgpdx');
            $table->unsignedBigInteger('sgdx')->nullable();
            $table->unsignedBigInteger('pdx')->nullable();
            $table->unsignedSmallInteger('sequence')->default(0);
            $table->string('components', 200)->default("구성");
            $table->integer('quantity_per_delivery')->default(0);
            $table->integer('quantity_per_month')->default(0);
            $table->unsignedTinyInteger('state')->default(10);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sgdx')->references('sgdx')->on('subscrib_goods');
            $table->foreign('pdx')->references('pdx')->on('products');
        });

        // 구독형 주문
        Schema::create('subscrib_orders', function (Blueprint $table) {
            $table->bigIncrements('sodx');
            $table->string('order_number')->default("0000-00-00-00-0");
            $table->unsignedBigInteger('udx')->nullable();
            $table->unsignedBigInteger('sgdx')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('pay_term', 20)->default("일시불");
            $table->date('start_date')->useCurrent();
            $table->date('end_date')->useCurrent();

            $table->unsignedBigInteger('total_amount')->default(0);
            $table->unsignedBigInteger('use_point')->default(0);
            $table->unsignedBigInteger('pay_amount')->default(0);
            $table->string('pay_kind', 10)->default("무통장");
            $table->string('pay_name', 100)->default("");
            $table->string('pay_company', 200)->default("");
            $table->string('pay_tel', 30)->default("");
            $table->string('pay_cell', 30)->default("");
            $table->string('pay_email', 200)->default("");

            $table->string('delivery_zipcode', 150)->default("");
            $table->string('delivery_address1')->default("");
            $table->string('delivery_address2')->default("");
            $table->string('delivery_name', 30)->default("");
            $table->string('delivery_tel', 30)->default("");
            $table->text('delivery_msg')->default("");
            $table->string('receipt_kind', 20)->default("세금계산서");
            $table->string('company_regist_number', 20)->default("");
            $table->string('company_name', 100)->default("");
            $table->string('company_president_name', 50)->default("");
            $table->string('company_kind1', 50)->default("");
            $table->string('company_kind2', 50)->default("");
            $table->string('company_charge_email', 250)->default("");
            $table->string('person_name', 50)->default("");
            $table->string('person_unique_number', 20)->default("");
            $table->unsignedTinyInteger('state')->default(10);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('udx')->references('udx')->on('users');
            $table->foreign('sgdx')->references('sgdx')->on('subscrib_goods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscrib_orders');
        Schema::dropIfExists('subscrib_good_products');
        Schema::dropIfExists('subscrib_goods');
        Schema::dropIfExists('subscrib_good_categories');
    }
}
