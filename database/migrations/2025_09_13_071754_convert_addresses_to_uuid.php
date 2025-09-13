<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertAddressesToUuid extends Migration
{
    // public function up()
    // {
    //     Schema::table('addresses', function (Blueprint $table) {
    //         $table->dropPrimary('PRIMARY');
    //         $table->dropColumn('id');
    //         $table->uuid('id')->primary()->first();
    //     });
    // }

    // public function down()
    // {
    //     Schema::table('addresses', function (Blueprint $table) {
    //         $table->dropPrimary('PRIMARY');
    //         $table->dropColumn('id');
    //         $table->id()->first();
    //     });
    // }
}
