<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertSchedulesToUuid extends Migration
{
    public function up()
    {
        // Dropar FKs
        try {
            Schema::table('schedules', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['room_id']);
                $table->dropForeign(['created_by']);
                $table->dropForeign(['hour_id']);
                $table->dropForeign(['data_nao_faturada_id']);
            });
        } catch (Exception $e) {}

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->uuid('id')->primary()->first();
            
            // Converter FKs para UUID
            $table->uuid('user_id')->change();
            $table->uuid('room_id')->change();
            $table->uuid('created_by')->change();
            $table->uuid('hour_id')->change();
            $table->uuid('data_nao_faturada_id')->nullable()->change();
        });

        // Recriar FKs
        Schema::table('schedules', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('hour_id')->references('id')->on('hours');
            $table->foreign('data_nao_faturada_id')->references('id')->on('data_nao_faturada');
        });
    }

    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['room_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['hour_id']);
            $table->dropForeign(['data_nao_faturada_id']);
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->id()->first();
            
            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('room_id')->change();
            $table->unsignedBigInteger('created_by')->change();
            $table->unsignedBigInteger('hour_id')->change();
            $table->unsignedBigInteger('data_nao_faturada_id')->nullable()->change();
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('hour_id')->references('id')->on('hours');
            $table->foreign('data_nao_faturada_id')->references('id')->on('data_nao_faturada');
        });
    }
}
