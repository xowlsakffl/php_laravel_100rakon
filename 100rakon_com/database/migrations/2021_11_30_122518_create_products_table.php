<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('pdx');
            $table->unsignedBigInteger('pcdx')->nullable();
            $table->unsignedSmallInteger('sequence')->default(0);
            $table->string('title', 150)->default("제목");
            $table->string('name', 150)->default("제품명");
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('quantity')->default(0);
            $table->text('content')->default("");
            $table->unsignedTinyInteger('state')->default(10);
            $table->unsignedBigInteger('hit')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pcdx')->references('pcdx')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
