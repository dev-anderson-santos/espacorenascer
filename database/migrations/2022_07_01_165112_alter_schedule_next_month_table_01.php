<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterScheduleNextMonthTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedule_next_month', function (Blueprint $table) {
            $table->unsignedBigInteger('data_nao_faturada_id')->nullable();

            $table->foreign('data_nao_faturada_id')->references('id')->on('data_nao_faturada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
