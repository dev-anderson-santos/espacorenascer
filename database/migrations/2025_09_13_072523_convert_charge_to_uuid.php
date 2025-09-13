<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertChargeToUuid extends Migration
{
    public function up()
    {
        // Dropar FKs
        try {
            Schema::table('charge', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['created_by']);
                $table->dropForeign(['updated_by']);
            });
        } catch (Exception $e) {}

        Schema::table('charge', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->uuid('id')->primary()->first();
            
            // Converter FKs para UUID
            $table->uuid('user_id')->change();
            $table->uuid('created_by')->change();
            $table->uuid('updated_by')->change();
        });

        // Recriar FKs
        Schema::table('charge', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('charge', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::table('charge', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->id()->first();
            
            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('created_by')->change();
            $table->unsignedBigInteger('updated_by')->change();
        });

        Schema::table('charge', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }
}
