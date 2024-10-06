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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('profiles');
            $table->unsignedBigInteger('barber_id')->nullable();
            $table->foreign('barber_id')->references('id')->on('profiles');
            $table->timestamp('assigned'); // fecha y hora de la cita
            $table->unsignedInteger('slots'); // cantidad de franjas horarias que se ocuparán
            $table->enum('status', ['RESERVADA', 'CANCELADA', 'TERMINADA', 'ACEPTADA'])->default('RESERVADA');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
