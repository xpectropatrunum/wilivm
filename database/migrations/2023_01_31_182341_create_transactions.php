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
        if (!Schema::hasTable('transactions')) {

            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->integer("order_id");
                $table->string("tx_id");
                $table->integer("status")->default(0)->comment("0 pending, 1 paid");
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
        //Schema::dropIfExists('transactions');
    }
};
