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
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // ID del producto
            $table->string('nombre'); // Nombre del producto
            $table->text('descripcion'); // Descripción del producto
            $table->decimal('precio', 8, 2); // Precio del producto con 2 decimales
            $table->integer('cantidad'); // Cantidad disponible del producto

            // Relación con categoría
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
