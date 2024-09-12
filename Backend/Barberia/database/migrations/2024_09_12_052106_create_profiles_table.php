<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id', false, true);
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('role_id', false, true);
            $table->foreign('role_id')->references('id')->on('roles');
            $table->bigInteger('barbershop_id', false, true);
            $table->foreign('barbershop_id')->references('id')->on('barbershops');
            $table->enum('status', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
