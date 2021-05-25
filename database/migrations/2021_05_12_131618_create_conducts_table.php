<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conducts', function (Blueprint $table) {
            $table->id();
            $table->float('mark')->nullable();
            $table->string('status')->nullable();
            $table->date('date')->nullable();
            $table->unsignedBigInteger('achievement_id')->nullable();
            $table->foreign('achievement_id')->references('id')->on('achievements');
//            $table->unsignedBigInteger('mark_id')->nullable();
//            $table->foreign('mark_id')->references('id')->on('marks');
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
        Schema::dropIfExists('conducts');
    }
}
