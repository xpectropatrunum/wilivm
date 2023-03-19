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
        Schema::create('blocked_users', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->string("from_datetime");
            $table->string("to_datetime");
            $table->text("description");
            $table->integer("enable");
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
        Schema::dropIfExists('block_users');
    }
};
