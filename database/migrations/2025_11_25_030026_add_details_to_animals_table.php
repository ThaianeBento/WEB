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
        Schema::table('animals', function (Blueprint $table) {
            $table->string('microchip')->nullable()->unique()->after('nome');
            $table->string('porte')->nullable()->after('peso'); // Pequeno, Médio, Grande
            $table->boolean('srd')->default(false)->after('raca');
            $table->boolean('data_nascimento_estimada')->default(false)->after('idade');
            $table->string('status_reprodutivo')->default('Desconhecido')->after('castrado'); // Inteiro, Castrado, Desconhecido
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn(['microchip', 'porte', 'srd', 'data_nascimento_estimada', 'status_reprodutivo']);
        });
    }
};
