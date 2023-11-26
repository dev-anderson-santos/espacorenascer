<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesHoursDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('schedules_hours_days', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('schedule_id')->nullable(false);
        //     $table->unsignedBigInteger('hour_id')->nullable(false);
        //     $table->unsignedBigInteger('days_of_week_id')->nullable(false);
        //     $table->softDeletes();
        //     $table->timestamps();

        //     $table->foreign('schedule_id')->references('id')->on('schedules');
        //     $table->foreign('hour_id')->references('id')->on('hours');
        //     $table->foreign('days_of_week_id')->references('id')->on('daysofweeks');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('schedules_hours_days');
    }
}
