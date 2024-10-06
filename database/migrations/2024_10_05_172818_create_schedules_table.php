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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barbershop_id'); // barbería a la que pertenece el horario
            $table->foreign('barbershop_id')->references('id')->on('barbershops');
            $table->string('day', 15); // día de la semana
            $table->time('start_time')->nullable(); // hora de inicio
            $table->time('end_time')->nullable(); // hora de fin
            $table->boolean('is_available')->default(true); // indica si el horario está disponible
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
