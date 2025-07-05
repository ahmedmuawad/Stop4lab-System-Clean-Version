<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');

            // address
            $table->string('address');

            //branche_id
            $table->unsignedBigInteger('branche_id');
            $table->foreign('branche_id')->references('id')->on('branches')->onDelete('cascade');

            // test_id
            $table->text('test_id');
            // $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');

            // culture_id
            $table->text('culture_id');
            // $table->foreign('culture_id')->references('id')->on('cultures')->onDelete('cascade');

            // package_id
            $table->unsignedBigInteger('package_id');
            // $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');

            // type
            $table->string('type');

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
        Schema::dropIfExists('bookings');
    }
}
