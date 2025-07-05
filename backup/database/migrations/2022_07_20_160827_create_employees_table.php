<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->unsigned();
            $table->decimal('salary');
            $table->tinyInteger('type')->comment('0 form flixable 1 for fixed (start,end)')->default(0);
            $table->tinyInteger('violation_status')->default(0);
            $table->time('shift_start')->nullable();
            $table->time('shift_end')->nullable();
            $table->date('job_start')->nullable();
            $table->integer('works_mins');
            $table->integer('age')->nullable();
            $table->integer('over_time')->default(0);
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
        Schema::dropIfExists('employees');
    }
}
