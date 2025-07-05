<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->string('url_pdf')->nullable();
            $table->string('print_type')->nullable();
            $table->string('printer_name')->nullable();
            $table->boolean('response')->default(0)->comment('0 => means still wait , 1 => done');
            $table->integer('count')->default(1)->comment('count of paper by defulte 1');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('printers');
    }
}
