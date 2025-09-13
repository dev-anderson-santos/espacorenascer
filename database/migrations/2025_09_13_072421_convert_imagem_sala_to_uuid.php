<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertImagemSalaToUuid extends Migration
{
    public function up()
    {
        // Primeiro dropar FKs se existirem
        try {
            Schema::table('imagem_sala', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
            });
        } catch (Exception $e) {}

        Schema::table('imagem_sala', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->uuid('id')->primary()->first();
            
            // Converter FK created_by para UUID
            $table->uuid('created_by')->change();
        });

        // Recriar FK
        Schema::table('imagem_sala', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('imagem_sala', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });

        Schema::table('imagem_sala', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->dropColumn('id');
            $table->id()->first();
            
            $table->unsignedBigInteger('created_by')->change();
        });

        Schema::table('imagem_sala', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users');
        });
    }
}
