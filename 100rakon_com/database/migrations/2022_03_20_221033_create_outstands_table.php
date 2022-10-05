<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutstandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outstands', function (Blueprint $table) {
            $table->bigIncrements('osdx');
            $table->unsignedBigInteger('oscdx')->nullable();
            $table->unsignedSmallInteger('sequence')->default(0);
            $table->string('title', 150)->default("제목");
            $table->string('name', 150)->default("제품명");
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('quantity')->default(0);
            $table->text('content')->default("");
            $table->unsignedTinyInteger('state')->default(10);
            $table->unsignedBigInteger('hit')->default(0);
            $table->integer('price_normal')->default(0);
            $table->integer('delivery_origin_cost')->default(0);
            $table->string('supply', 150)->default('제조사');
            $table->boolean('need_delivery_info')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('oscdx')->references('oscdx')->on('outstand_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outstands');
    }
}
