<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertPivotTablesToUuid extends Migration
{
    public function up()
    {
        // Tabela users_has_addresses
        try {
            Schema::table('users_has_addresses', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['address_id']);
            });
        } catch (Exception $e) {}

        Schema::table('users_has_addresses', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->uuid('id')->primary()->first();
            
            $table->uuid('user_id')->change();
            $table->uuid('address_id')->change();
        });

        Schema::table('users_has_addresses', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('address_id')->references('id')->on('addresses');
        });

        // Tabela room_has_addresses
        try {
            Schema::table('room_has_addresses', function (Blueprint $table) {
                $table->dropForeign(['room_id']);
                $table->dropForeign(['address_id']);
            });
        } catch (Exception $e) {}

        Schema::table('room_has_addresses', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->uuid('id')->primary()->first();
            
            $table->uuid('room_id')->change();
            $table->uuid('address_id')->change();
        });

        Schema::table('room_has_addresses', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('address_id')->references('id')->on('addresses');
        });

        // Tabela schedules_hours_days
        try {
            Schema::table('schedules_hours_days', function (Blueprint $table) {
                $table->dropForeign(['schedule_id']);
                $table->dropForeign(['hour_id']);
                $table->dropForeign(['days_of_week_id']);
            });
        } catch (Exception $e) {}

        Schema::table('schedules_hours_days', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->uuid('id')->primary()->first();
            
            $table->uuid('schedule_id')->change();
            $table->uuid('hour_id')->change();
            $table->uuid('days_of_week_id')->change();
        });

        Schema::table('schedules_hours_days', function (Blueprint $table) {
            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->foreign('hour_id')->references('id')->on('hours');
            $table->foreign('days_of_week_id')->references('id')->on('daysofweeks');
        });
    }

    public function down()
    {
        // Reverter users_has_addresses
        Schema::table('users_has_addresses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['address_id']);
        });

        Schema::table('users_has_addresses', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->id()->first();
            
            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('address_id')->change();
        });

        Schema::table('users_has_addresses', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('address_id')->references('id')->on('addresses');
        });

        // Reverter room_has_addresses
        Schema::table('room_has_addresses', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['address_id']);
        });

        Schema::table('room_has_addresses', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->id()->first();
            
            $table->unsignedBigInteger('room_id')->change();
            $table->unsignedBigInteger('address_id')->change();
        });

        Schema::table('room_has_addresses', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('address_id')->references('id')->on('addresses');
        });

        // Reverter schedules_hours_days
        Schema::table('schedules_hours_days', function (Blueprint $table) {
            $table->dropForeign(['schedule_id']);
            $table->dropForeign(['hour_id']);
            $table->dropForeign(['days_of_week_id']);
        });

        Schema::table('schedules_hours_days', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->id()->first();
            
            $table->unsignedBigInteger('schedule_id')->change();
            $table->unsignedBigInteger('hour_id')->change();
            $table->unsignedBigInteger('days_of_week_id')->change();
        });

        Schema::table('schedules_hours_days', function (Blueprint $table) {
            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->foreign('hour_id')->references('id')->on('hours');
            $table->foreign('days_of_week_id')->references('id')->on('daysofweeks');
        });
    }
}
