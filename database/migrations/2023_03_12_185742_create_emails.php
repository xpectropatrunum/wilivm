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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("title");
            $table->string("head");
            $table->text("template");
            $table->integer("enabled");
            $table->integer("type")->default(0)->comment("0 register, 1 verify, 2 invoice, 3 invoice payed, 4 server deploying, 5 rating tickets");
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
        Schema::dropIfExists('emails');
    }
};
