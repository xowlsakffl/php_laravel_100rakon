<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsSendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_sends', function (Blueprint $table) {

            $table->bigIncrements('idx');
            $table->unsignedBigInteger('udx')->nullable();
            $table->unsignedBigInteger('odx')->nullable();
            $table->string('sender', 30)->default("");
            $table->string('receiver', 30)->default("");
            $table->text('msg')->default("");
            $table->string('msg_type', 10)->default("");
            $table->text('title')->default("");
            $table->string('destination', 10)->default("");
            $table->string('rdate', 10)->default("YYYYMMDD");
            $table->string('rtime', 10)->default("HHII");
            $table->string('image', 10)->default("");
            $table->string('testmode_yn', 1)->default("");

            $table->integer('result_code')->default(0);
            $table->string('messsage')->default("");
            $table->integer('msg_id')->default(0);
            $table->integer('success_cnt')->default(0);
            $table->integer('error_cnt')->default(0);

            $table->unsignedTinyInteger('state')->default(10);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('udx')->references('udx')->on('users');
            $table->foreign('odx')->references('odx')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_sends');
    }
}
