<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_schedules', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('employee_id')->unsigned();
            $table->integer('work_mins')->nullable();
            $table->integer('over_time')->default(0);
            $table->dateTime('start_shift')->nullable();
            $table->dateTime('end_shift')->nullable();
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
        Schema::dropIfExists('employees_schedules');
    }
}
