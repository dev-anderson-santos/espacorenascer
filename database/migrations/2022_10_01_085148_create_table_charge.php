<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCharge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('amount', 9, 2);
            $table->dateTime('payday');
            $table->string('status', 1);
            $table->uuid('user_id')->nullable(false);
            $table->uuid('created_by')->nullable(false);
            $table->uuid('updated_by')->nullable(false);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_charge');
    }
}
