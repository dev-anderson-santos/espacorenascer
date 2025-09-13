<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertSettingsLogToUuid extends Migration
{
    public function up()
    {
        // Dropar FKs
        try {
            Schema::table('settings_log', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['settings_id']);
            });
        } catch (Exception $e) {}

        Schema::table('settings_log', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->uuid('id')->primary()->first();
            
            // Converter FKs para UUID
            $table->uuid('user_id')->change();
            $table->uuid('settings_id')->change();
        });

        // Recriar FKs
        Schema::table('settings_log', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('settings_id')->references('id')->on('settings');
        });
    }

    public function down()
    {
        Schema::table('settings_log', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['settings_id']);
        });

        Schema::table('settings_log', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->id()->first();
            
            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('settings_id')->change();
        });

        Schema::table('settings_log', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('settings_id')->references('id')->on('settings');
        });
    }
}
