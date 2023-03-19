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
        if (!Schema::hasTable('user_service_requests')) {

            Schema::create('user_service_requests', function (Blueprint $table) {
                $table->id();
                $table->integer("user_service_id");
                $table->integer("request_id");
                $table->integer("status")->default(1)->comment("0 pending, 1 done");
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
        //Schema::dropIfExists('user_service_requests');
    }
};
