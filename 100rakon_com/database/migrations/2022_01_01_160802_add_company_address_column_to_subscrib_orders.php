<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyAddressColumnToSubscribOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscrib_orders', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->integer('term')->default(0);
            $table->integer('delivery_times')->default(0);
            $table->string('company_address', 300)->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscrib_orders', function (Blueprint $table) {
            $table->integer('quantity')->default(0);
            $table->dropColumn('term');
            $table->dropColumn('delivery_times');
            $table->dropColumn('company_address');
        });
    }
}
