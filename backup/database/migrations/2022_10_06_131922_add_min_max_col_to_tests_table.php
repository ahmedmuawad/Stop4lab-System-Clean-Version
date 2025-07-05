<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinMaxColToTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->string('decreased_in')->nullable();
            $table->string('increased_in')->nullable();
            $table->integer('min')->default(0);
            $table->integer('max')->default(1000);
            $table->integer('lab_out_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tests', function (Blueprint $table) {
            //
        });
    }
}
