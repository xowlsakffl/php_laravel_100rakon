<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderNameTelColumnTo2orderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->string('order_name', 50)->default("");
            $table->string('order_tel', 30)->default("");
        });
        Schema::table('subscrib_orders', function (Blueprint $table) {
            //
            $table->string('order_name', 50)->default("");
            $table->string('order_tel', 30)->default("");
            $table->dropColumn('pay_cell');
            $table->dropColumn('pay_email');
            $table->dropColumn('pay_company');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropColumn('order_name');
            $table->dropColumn('order_tel');
        });
        Schema::table('subscrib_orders', function (Blueprint $table) {
            //
            $table->dropColumn('order_name');
            $table->dropColumn('order_tel');
            $table->string('pay_cell', 30)->default("");
            $table->string('pay_email', 200)->default("");
            $table->string('pay_company', 200)->default("");
        });
    }
}
