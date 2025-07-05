<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFigToGroupTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_tests', function (Blueprint $table) {

            $table->longText('fig_1')->nullable();
            $table->longText('fig_2')->nullable();
            $table->longText('fig_3')->nullable();
            $table->longText('fig_4')->nullable();

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
