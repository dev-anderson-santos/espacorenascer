<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHistoric extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historic', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('action')->nullable();
            $table->uuid('user_id')->nullable();
            $table->uuid('room_id')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('hour_id')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('status')->nullable();
            $table->string('tipo')->nullable();
            $table->smallInteger('faturado')->nullable();
            $table->dateTime('finalizado_em')->nullable();
            $table->uuid('data_nao_faturada_id')->nullable();
            $table->timestamp('last_login_time')->nullable();
            $table->string('last_login_ip')->nullable();
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
        Schema::dropIfExists('table_history');
    }
}
