<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('ventas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('comprador_id');
        $table->string('ticket')->nullable();
        $table->enum('estado', ['pendiente', 'completada', 'cancelada'])->default('pendiente');
        $table->decimal('total', 10, 2)->default(0);
        $table->timestamps();

        $table->foreign('comprador_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
