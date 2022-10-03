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
        Schema::create('jamaap_charts', function (Blueprint $table) {
            $table->id();
            $table->string("OriginalMail")->nullable();
            $table->string("FromName")->nullable();
            $table->string("MessageStream")->nullable();
            $table->json("FromFull")->nullable();
            $table->string("To")->nullable();
            $table->json("ToFull")->nullable();
            $table->string("Cc")->nullable();
            $table->json("CcFull")->nullable();
            $table->string("Bcc")->nullable();
            $table->json("BccFull")->nullable();
            $table->string("OriginalRecipient")->nullable();
            $table->string("Subject")->nullable();
            $table->string("MessageID")->nullable();
            $table->string("ReplyTo")->nullable();
            $table->string("MailboxHash")->nullable();
            $table->string("Date")->nullable();
            $table->mediumText("TextBody")->nullable();
            $table->text("HtmlBody")->nullable();
            $table->mediumText("StrippedTextReply")->nullable();
            $table->text("RawEmail")->nullable();
            $table->text("Tag")->nullable();
            $table->json("Headers")->nullable();
            $table->json("Attachments")->nullable();
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
        Schema::dropIfExists('jamaap_charts');
    }
};
