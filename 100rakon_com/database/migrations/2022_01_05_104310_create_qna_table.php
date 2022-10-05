<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQnaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qnas', function (Blueprint $table) {
            $table->bigIncrements('idx');
            $table->string('name', 150)->default("이름");
            $table->string('tel', 30)->default("연락처");
            $table->string('email', 150)->default("이메일");
            $table->unsignedBigInteger('udx')->nullable();
            $table->integer('parent')->default(0);
            $table->text('content')->default("");
            $table->unsignedTinyInteger('state')->default(10);
            $table->unsignedBigInteger('hit')->default(0);
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
        Schema::dropIfExists('qnas');
    }
}
