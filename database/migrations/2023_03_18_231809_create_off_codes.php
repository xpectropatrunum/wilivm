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
        Schema::create('off_codes', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->string("code");
            $table->integer("type")->default(0);
            $table->float("amount");
            $table->integer("limit")->default(0);
            $table->integer("current")->default(0);
            $table->integer("enable")->default(1);
            $table->string("from_date");
            $table->string("to_date");
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
        Schema::dropIfExists('off_codes');
    }
};
