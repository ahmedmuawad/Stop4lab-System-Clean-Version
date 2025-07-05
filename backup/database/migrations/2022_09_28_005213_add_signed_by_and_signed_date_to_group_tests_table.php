<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignedByAndSignedDateToGroupTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_tests', function (Blueprint $table) {
            $table->integer('signed_by')->nullable();
            $table->string('signed_date')->nullable();
            $table->integer('review_by')->nullable();
            $table->string('review_date')->nullable();
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
