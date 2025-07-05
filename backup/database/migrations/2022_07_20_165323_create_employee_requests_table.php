<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_requests', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('employee_id')->unsigned();
            $table->dateTime('request_from')->nullable();
            $table->dateTime('request_to')->nullable();
            $table->integer('durations')->nullable();
            $table->date('day')->nullable();
            $table->string('notes',500)->nullable();
            $table->integer('status')->nullable();
            $table->tinyInteger('type')->comment('0 to permetion || 1 to vocations')->default(0);
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
        Schema::dropIfExists('employee_requests');
    }
}
