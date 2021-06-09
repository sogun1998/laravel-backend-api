<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhuhuynhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phuhuynhs', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable();
            $table->string('phone')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->boolean('firstLogin')->default(false);
            $table->foreign('student_id')->references('id')->on('students');
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
        Schema::dropIfExists('phuhuynhs');
    }
}
