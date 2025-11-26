<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgendamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Agendamento::create([
            'data_agendamento' => '2023-11-25',
            'horario' => '09:00',
            'animal_id' => 1,
            'tutor_id' => 1,
            'convenio_id' => 1,
            'valor' => 150.00,
            'status' => 'Confirmado',
            'observacoes' => 'Trazer jejum de 8h.',
            'mutirao_id' => 1, // Mutirao Concluído
        ]);

        \App\Models\Agendamento::create([
            'data_agendamento' => '2023-11-26',
            'horario' => '14:30',
            'animal_id' => 2,
            'tutor_id' => 2,
            'convenio_id' => 2,
            'valor' => 120.00,
            'status' => 'Agendado',
            'observacoes' => '',
            'mutirao_id' => 2, // Mutirao Aberto
        ]);

        \App\Models\Agendamento::create([
            'data_agendamento' => '2023-11-27',
            'horario' => '10:00',
            'animal_id' => 3,
            'tutor_id' => 1, // Thor belongs to tutor 1
            'convenio_id' => 1,
            'valor' => 100.00,
            'status' => 'Agendado',
            'observacoes' => 'Animal arisco.',
            'mutirao_id' => 2, // Mutirao Aberto
        ]);

        \App\Models\Agendamento::create([
            'data_agendamento' => '2023-11-24',
            'horario' => '16:00',
            'animal_id' => 4,
            'tutor_id' => 3, // Luna belongs to tutor 3
            'convenio_id' => 3,
            'valor' => 50.00,
            'status' => 'Realizado',
            'observacoes' => '',
            'mutirao_id' => 1, // Mutirao Concluído
        ]);
    }
}
