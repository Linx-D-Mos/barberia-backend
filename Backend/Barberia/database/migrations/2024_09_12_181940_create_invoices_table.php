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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->decimal('total', 10, 2)->nullable();
            $table->enum('payment_method', ['EFECTIVO', 'TRANSFERENCIA', 'TARJETA']);
            $table->enum('status', ['PENDIENTE', 'PAGADO', 'CANCELADO'])->default('PENDIENTE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
