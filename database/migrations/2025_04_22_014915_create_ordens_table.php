<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con usuarios
            $table->dateTime('fecha');
            $table->decimal('total', 10, 2)->default(0); // Total de la orden
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordens');
    }
};
