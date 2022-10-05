<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutstandCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outstand_categories', function (Blueprint $table) {
            $table->bigIncrements('oscdx');
            $table->unsignedSmallInteger('sequence')->default(0);
            $table->string('cname', 100)->default("");
            $table->unsignedSmallInteger('parent')->default(0);
            $table->unsignedTinyInteger('state')->default(10);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outstand_categories');
    }
}
