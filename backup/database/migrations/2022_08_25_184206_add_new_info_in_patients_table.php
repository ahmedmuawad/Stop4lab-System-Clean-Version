<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewInfoInPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('phone2')->nullable();
            $table->date('date_pms')->nullable();
            $table->integer('hours_fasting')->nullable();
            $table->boolean('gland')->default(0);
            $table->boolean('tumors')->default(0);
            $table->boolean('antibiotic')->default(0);
            $table->boolean('iron')->default(0);
            $table->boolean('cortisone')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            //
        });
    }
}
