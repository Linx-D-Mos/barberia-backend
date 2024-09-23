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
        Schema::create('logs', function (Blueprint $table) {
            $table->id(); // Clave primaria para la entrada del registro de auditoría
            $table->unsignedBigInteger(column: 'profile_id'); // Clave foránea que referencia al usuario que realizó la peticion
            $table->foreign('profile_id')->references('id')->on('profiles');
            $table->string('table_name'); // Nombre de la tabla afectada
            $table->enum('operation', ['Create', 'Update', 'Delete']); // Tipo de operación realizada
            $table->string('function'); // Nombre de la función que realizó la petición
            $table->string('row_id')->nullable(); // Id de la fila afectada (si aplica)
            $table->json('old_values')->nullable(); // Valores antiguos de la fila afectada (si aplica)
            $table->json('new_values')->nullable(); // Valores nuevos de la fila afectada (si aplica)
            $table->ipAddress('ip_address')->nullable(); // Dirección IP del cliente que realizó la petición
            $table->string('user_agent')->nullable(); // Agente de usuario del cliente que realizó la petición
            $table->string('browser')->nullable(); // Navegador del cliente que realizó la petición
            $table->string('platform')->nullable(); // Plataforma del cliente que realizó la petición
            $table->timestamp('created_at')->nullable(); // Fecha y hora de creación del registro
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
