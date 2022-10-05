<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('udx');
            $table->string('email')->unique()->default("");
            $table->string('password')->default("");
            $table->string('name', 150)->default("");
            $table->char('email_auth', 1)->default("N");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('cell', 20)->default("");
            $table->char('cell_auth', 1)->default("N");
            $table->timestamp('cell_authed_at')->nullable();
            $table->string('tel', 20)->default("");
            $table->string('join_from', 10)->default("home");
            $table->string('super')->default("N");
            $table->unsignedTinyInteger('state')->default(10);
            $table->char('personal_agree', 1)->default("");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
