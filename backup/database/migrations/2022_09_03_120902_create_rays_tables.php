<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaysTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ray_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('rays', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->nullable();
            $table->string('name')->nullable();
            $table->string('shortcut')->nullable();
            // $table->string('sample_type')->nullable();
            $table->decimal('price')->default(0.00);
            $table->integer('num_day_receive')->nullable();
            $table->timestamps();
        });
        Schema::create('group_rays', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id')->unsigned();
            $table->integer('ray_id')->unsigned();
            $table->decimal('price');
            $table->boolean('has_results')->default(0);
            $table->boolean('checked')->default(1);
            $table->timestamps();
        });
        Schema::create('group_ray_results', function (Blueprint $table) {
            $table->id();
            $table->integer('group_ray_id');
            $table->integer('ray_id');
            $table->text('comment');
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
        Schema::dropIfExists('ray_categories');
        Schema::dropIfExists('rays');
        Schema::dropIfExists('group_rays');
        Schema::dropIfExists('group_ray_results');
    }
}
