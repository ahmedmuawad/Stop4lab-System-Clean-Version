<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashVault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_vault', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->decimal('begin_cash')->default(0);
            $table->decimal('end_cash')->nullable();
            $table->integer('branche_id')->unsigned();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('cash_vault');
    }
}
