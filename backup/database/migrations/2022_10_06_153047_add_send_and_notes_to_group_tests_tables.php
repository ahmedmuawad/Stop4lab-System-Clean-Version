<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSendAndNotesToGroupTestsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_tests', function (Blueprint $table) {
            $table->tinyInteger('send_status')->nullable();
            $table->string('send_date')->nullable();
            $table->string('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_tests', function (Blueprint $table) {
            //
        });
    }
}
