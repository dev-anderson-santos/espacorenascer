<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable(false);
            $table->uuid('room_id')->nullable(false);
            $table->uuid('created_by')->nullable(false);
            $table->uuid('hour_id')->nullable(false);
            $table->dateTime('date');
            $table->enum('status', ['Ativo', 'Finalizado'])->default('Ativo');
            $table->enum('tipo', ['Avulso', 'Fixo'])->default('Avulso');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('hour_id')->references('id')->on('hours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
