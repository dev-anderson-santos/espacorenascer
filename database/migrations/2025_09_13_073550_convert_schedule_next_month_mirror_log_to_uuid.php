<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertScheduleNextMonthMirrorLogToUuid extends Migration
{
    public function up()
    {
        Schema::table('schedule_next_month_mirror_log', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->uuid('id')->primary()->first();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule_next_month_mirror_log', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->id()->first();
        });
    }
}
