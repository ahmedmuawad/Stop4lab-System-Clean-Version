<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCycleColsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_tests', function (Blueprint $table) {
            //chech tests
            $table->integer('check_test_by')->nullable();
            $table->string('check_test_date')->nullable();

            //results
            $table->integer('results_by')->nullable();
            // results date = upldated_at
        });
        Schema::table('groups', function (Blueprint $table) {
            //barcode
            $table->integer('barcoded_by')->nullable();
            $table->string('barcoded_date')->nullable();

            // working paper
            $table->integer('working_paper_by')->nullable();    
            $table->string('working_paper_date')->nullable();

            // review
            $table->integer('review_by')->nullable();    
            $table->string('review_date')->nullable();

            // medical print
            $table->integer('medical_print_by')->nullable();    
            $table->string('medical_print_date')->nullable();

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

        });
        Schema::table('groups', function (Blueprint $table) {

        });
    }
}
