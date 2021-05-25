<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveAndSemesterToConductSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conduct_summaries', function (Blueprint $table) {
            //
            $table->integer('isActive')->default(0)->after('mark');
            $table->string('semester')->nullable()->after('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conduct_summaries', function (Blueprint $table) {
            //
            $table->dropColumn('isActive');
            $table->dropColumn('semester');
        });
    }
}
