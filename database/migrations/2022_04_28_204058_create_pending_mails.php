<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_mails', function (Blueprint $table) {
            $table->id();
            $table->string("to")->nullable();
            $table->string("to_name")->nullable();
            $table->string("reply_to")->nullable();
            $table->string("mail_from")->nullable();
            $table->string("from_name")->nullable();
            $table->string("subject")->nullable();
            $table->mediumText("body")->nullable();
            $table->mediumText("template")->nullable();
            $table->mediumText("signature")->nullable();
            $table->mediumText("attachment")->nullable();
            $table->mediumText("user")->nullable();
            $table->tinyInteger("state")->default(0);
            $table->string("type")->nullable();
            $table->string("url")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_mails');
    }
};
