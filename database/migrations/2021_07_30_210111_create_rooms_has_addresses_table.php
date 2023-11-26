<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsHasAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms_has_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id')->nullable(false);
            $table->unsignedBigInteger('addresses_id')->nullable(false);
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('addresses_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms_has_addresses');
    }
}
