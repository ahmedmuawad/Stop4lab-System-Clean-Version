<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesCustodyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches_custody', function (Blueprint $table) {
            $table->id();
            $table->integer('branche_id');
            $table->tinyInteger('custody_type')->default(0)->comment('0 => out , 1 => presonal , 2 => form lab');
            $table->decimal('custody')->default(0.00);
            $table->string('priceable_type')->nullable();
            $table->integer('priceable_id')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 for pending , 1 for active');
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('branches_custody');
    }
}
