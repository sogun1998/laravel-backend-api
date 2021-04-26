<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable();
            $table->string('phone')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('gender')->nullable();
//            $table->timestamp('verify_at')->nullable();
//            $table->timestamp('create_at')->nullable();
//            $table->timestamp('update_at')->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedBigInteger('lophoc_id')->nullable();
            $table->foreign('lophoc_id')->references('id')->on('lophocs')->onDelete('cascade');;
            $table->string('school')->nullable();
            $table->boolean('firstLogin')->default(false);
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
        Schema::dropIfExists('students');
    }
}
