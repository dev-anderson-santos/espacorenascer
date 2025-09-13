<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('cpf')->nullable(true)->unique();
            $table->string('inscricao_crp_crm')->nullable(true);
            $table->date('birth_date')->nullable(true);
            $table->text('academic_formations')->nullable(true);
            $table->text('syndromes_special_situations_experience')->nullable(true);
            $table->text('age_range_service')->nullable(true);
            $table->text('approach_lines')->nullable(true);
            $table->smallInteger('is_admin')->nullable(true);
            $table->smallInteger('status')->default('1');
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
