<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mark_details', function (Blueprint $table) {
            $table->id();
            $table->float('mark')->nullable();
            $table->string('status');
            $table->string('comment');
            $table->unsignedBigInteger('test_id')->nullable();
            $table->foreign('test_id')->references('id')->on('tests');
            $table->unsignedBigInteger('mark_id')->nullable();
            $table->foreign('mark_id')->references('id')->on('marks');
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
        Schema::dropIfExists('mark_details');
    }
}
