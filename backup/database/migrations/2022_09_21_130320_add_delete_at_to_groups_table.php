<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteAtToGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dateTime('deleted_at')->nullable();
            $table->boolean('delete_type')->comment('0 & NULL => delete , 1 => retrieved')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->decimal('retrieve_amount')->default(0.00);
            $table->tinyInteger('retrieve_type')->nullable();
            $table->string('retrieve_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            //
        });
    }
}
