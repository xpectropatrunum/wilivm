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
        if (!Schema::hasTable('user_services')) {

            Schema::create('user_services', function (Blueprint $table) {
                $table->id();
                $table->integer("user_id");
                $table->string("type");
                $table->string("plan");
                $table->string("ram");
                $table->string("cpu");
                $table->string("bandwith");
                $table->string("storage");
                $table->string("ip")->nullable();
                $table->string("username")->nullable();
                $table->string("password")->nullable();
                $table->string("os");
                $table->string("location");
                $table->integer("status")->default(1)->comment("1 not paid, 2 enabled, 3 expired, 4 canceled, 5 pending");;
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_services');
    }
};
