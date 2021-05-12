<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHictoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hictories', function (Blueprint $table) {
            $table->id();
            $table->string('text')->nullable();;
            $table->float('old_score')->nullable();
            $table->float('new_score')->nullable();
            $table->integer('status')->nullable();
            $table->unsignedBigInteger('markDetail_id')->nullable();
            $table->foreign('markDetail_id')->references('id')->on('mark_details');
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
        Schema::dropIfExists('hictories');
    }
}
