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
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->date('data_agendamento');
            $table->time('horario')->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->string('status')->default('Agendado');
            $table->text('observacoes')->nullable();
            $table->foreignId('animal_id')->constrained('animals')->onDelete('cascade');
            $table->foreignId('tutor_id')->nullable()->constrained('tutors')->onDelete('set null');
            $table->foreignId('convenio_id')->nullable()->constrained('convenios')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
