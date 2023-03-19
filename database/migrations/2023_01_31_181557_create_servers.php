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
        if (!Schema::hasTable('servers')) {

            Schema::create('servers', function (Blueprint $table) {
                $table->id();
                $table->integer("server_type_id");
                $table->integer("server_plan_id");
                $table->string("cpu");
                $table->string("ram");
                $table->string("bandwith");
                $table->string("storage");
                $table->float("price");
                $table->integer("enabled")->default(0);
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
        //Schema::dropIfExists('servers');
    }
};
