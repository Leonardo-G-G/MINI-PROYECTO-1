<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->string('autor');
            $table->string('editorial')->nullable();
            $table->integer('numero_paginas')->nullable();
            $table->enum('estado', ['Nuevo', 'Seminuevo', 'Usado'])->default('Nuevo');
            $table->decimal('precio', 8, 2);
            $table->integer('cantidad')->default(1);
            $table->string('foto')->nullable();
            $table->year('anio_publicacion')->nullable();
            $table->foreignId('vendedor_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
