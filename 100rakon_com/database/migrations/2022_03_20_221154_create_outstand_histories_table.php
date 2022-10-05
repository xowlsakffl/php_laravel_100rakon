<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutstandHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outstand_histories', function (Blueprint $table) {
            $table->bigIncrements('idx');
            $table->unsignedBigInteger('osodx');
            $table->string('kind', 20)->default("기타");
            $table->text('content')->default("");
            $table->timestamps();

            $table->foreign('osodx')->references('osodx')->on('outstand_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outstand_histories');
    }
}
