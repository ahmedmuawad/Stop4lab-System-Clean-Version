<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLabToLabColsToTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->boolean('lab_to_lab_status',1)->default(0)->comment('0 => in , 1 => out');
            $table->decimal('lab_to_lab_cost')->default(0)->comment('cost of lab to lab out');
        });
        Schema::table('packages', function (Blueprint $table) {
            $table->boolean('lab_to_lab_status',1)->default(0)->comment('0 => in , 1 => out');
            $table->decimal('lab_to_lab_cost')->default(0)->comment('cost of lab to lab out');
        });
        Schema::table('cultures', function (Blueprint $table) {
            $table->boolean('lab_to_lab_status',1)->default(0)->comment('0 => in , 1 => out');
            $table->decimal('lab_to_lab_cost')->default(0)->comment('cost of lab to lab out');
        });
        Schema::table('groups', function (Blueprint $table) {
            $table->decimal('cost')->default(0)->comment('cost of lab to lab out');
            $table->decimal('total_after_cost')->default(0);
        });
        Schema::table('group_tests', function (Blueprint $table) {
            // $table->boolean('lab_to_lab_status',1)->default(0)->comment('0 => in , 1 => out');
            $table->decimal('lab_to_lab_cost')->default(0)->comment('cost of lab to lab out');
        });
        Schema::table('group_cultures', function (Blueprint $table) {
            // $table->boolean('lab_to_lab_status',1)->default(0)->comment('0 => in , 1 => out');
            $table->decimal('lab_to_lab_cost')->default(0)->comment('cost of lab to lab out');
        });
        Schema::table('group_packages', function (Blueprint $table) {
            // $table->boolean('lab_to_lab_status',1)->default(0)->comment('0 => in , 1 => out');
            $table->decimal('lab_to_lab_cost')->default(0)->comment('cost of lab to lab out');
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
        Schema::table('cultures', function (Blueprint $table) {
            //
        });
        Schema::table('groups', function (Blueprint $table) {
            //
        });
        Schema::table('group_tests', function (Blueprint $table) {
            //
        });
        Schema::table('packages', function (Blueprint $table) {
            //
        });
        Schema::table('group_cultures', function (Blueprint $table) {
            //
        });
        Schema::table('group_packages', function (Blueprint $table) {
            //
        });
    }
}
