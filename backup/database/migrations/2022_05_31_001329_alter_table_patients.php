<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePatients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patients', function(Blueprint $table)
		{
			// $table->boolean('fluid_patient')->nullable();
            // $table->boolean('diabetic')->nullable();
            // $table->boolean('liver_patient')->nullable();
            // $table->boolean('pregnant')->nullable();
            // $table->text('other')->nullable();
		});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function(Blueprint $table)
		{
			// $table->boolean('fluid_patient')->nullable();
            // $table->boolean('diabetic')->nullable();
            // $table->boolean('liver_patient')->nullable();
            // $table->boolean('pregnant')->nullable();
            // $table->text('other')->nullable();
		});
    }
}
