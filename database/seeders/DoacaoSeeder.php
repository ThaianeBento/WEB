<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assuming we create some animals specifically for donation history
        $animal1 = \App\Models\Animal::create([
            'nome' => 'Paçoca (Adotado)',
            'especie' => 'Cachorro',
            'raca' => 'Vira-lata',
            'sexo' => 'Macho',
            'tutor_id' => 4, // ONG
            'status' => 'Adotado',
            'castrado' => true,
            'disponivel_doacao' => false,
        ]);

        \App\Models\Doacao::create([
            'animal_id' => $animal1->id,
            'data_doacao' => '2023-11-20',
            'adotante_nome' => 'Carlos Pereira',
            'adotante_contato' => '(11) 9999-8888',
            'observacoes' => 'Adotado em feira de adoção.'
        ]);
    }
}
