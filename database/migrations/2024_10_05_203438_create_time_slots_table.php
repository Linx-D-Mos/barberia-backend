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
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barber_id'); // barbero al que pertenece la franja horaria
            $table->foreign('barber_id')->references('id')->on('profiles');
            $table->string('day', 15); // día de la semana
            $table->time('start_time'); // hora de inicio
            $table->time('end_time'); // hora de fin
            $table->boolean('is_taken')->default(false); // indica si la franja horaria está ocupada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
