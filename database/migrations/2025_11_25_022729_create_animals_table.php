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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('especie');
            $table->string('raca')->nullable();
            $table->string('idade')->nullable();
            $table->decimal('peso', 8, 2)->nullable();
            $table->string('sexo');
            $table->string('cor')->nullable();
            $table->boolean('castrado')->default(false);
            $table->boolean('disponivel_doacao')->default(false);
            $table->text('observacoes')->nullable();
            $table->string('foto_url')->nullable();
            $table->foreignId('tutor_id')->constrained('tutors')->onDelete('cascade');
            $table->string('status')->default('Aguardando Avaliação');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
