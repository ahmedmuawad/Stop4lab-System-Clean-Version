<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSycleToCulturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_cultures' , function(Blueprint $table) {
            //chech tests
            $table->integer('check_test_by')->nullable();
            $table->boolean('check_test')->default(1);
            $table->string('check_test_date')->nullable();

            //results
            $table->integer('results_by')->nullable();
            // results date = upldated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_cultures', function (Blueprint $table) {
            //
        });
    }
}
