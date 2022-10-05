<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutstandOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outstand_orders', function (Blueprint $table) {
            $table->bigIncrements('osodx');
            $table->string('order_number')->default("0000-00-00-00-0");
            $table->unsignedBigInteger('udx')->nullable();
            $table->unsignedBigInteger('total_amount')->default(0);
            $table->unsignedBigInteger('use_point')->default(0);
            $table->unsignedBigInteger('pay_amount')->default(0);
            $table->string('pay_kind', 10)->default("무통장");
            $table->string('pay_name', 100)->default("");
            $table->string('pay_tel', 30)->default("");
            $table->string('delivery_zipcode', 150)->default("")->nullable();
            $table->string('delivery_address1')->default("")->nullable();
            $table->string('delivery_address2')->default("")->nullable();
            $table->string('delivery_name', 30)->default("")->nullable();
            $table->string('delivery_tel', 30)->default("")->nullable();
            $table->text('delivery_msg')->default("")->nullable();
            $table->string('receipt_kind', 20)->default("세금계산서");
            $table->string('company_regist_number', 20)->default("");
            $table->string('company_name', 100)->default("");
            $table->string('company_president_name', 50)->default("");
            $table->string('company_kind1', 50)->default("");
            $table->string('company_kind2', 50)->default("");
            $table->string('company_charge_email', 250)->default("");
            $table->string('company_address', 300)->default("");
            $table->string('person_name', 50)->default("");
            $table->string('person_unique_number', 20)->default("");
            $table->string('order_name', 50)->default("");
            $table->string('order_tel', 30)->default("");
            $table->unsignedTinyInteger('state')->default(10);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('udx')->references('udx')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outstand_orders');
    }
}
