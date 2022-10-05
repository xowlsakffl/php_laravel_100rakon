<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('uadx');
            $table->unsignedBigInteger('udx');
            $table->string('title', 50)->default("");
            $table->string('zipcode', 150)->default("");
            $table->string('address1')->default("");
            $table->string('address2')->default("");
            $table->string('name', 30)->default("");
            $table->string('tel', 30)->default("");
            $table->text('msg')->default("");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('udx')->references('udx')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
