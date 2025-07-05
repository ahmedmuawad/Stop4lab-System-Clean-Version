<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsCanceledToGroupsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_tests', function (Blueprint $table) {
            $table->boolean('is_canceled')->default(0);
        });
        Schema::table('group_rays', function (Blueprint $table) {
            $table->boolean('is_canceled')->default(0);
        });
        Schema::table('group_cultures', function (Blueprint $table) {
            $table->boolean('is_canceled')->default(0);
        });
        Schema::table('group_packages', function (Blueprint $table) {
            $table->boolean('is_canceled')->default(0);
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
        Schema::table('group_rays', function (Blueprint $table) {
        });
        Schema::table('group_cultures', function (Blueprint $table) {
        });
        Schema::table('group_packages', function (Blueprint $table) {
        });
    }
}
