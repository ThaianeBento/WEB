<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Animal::create([
            'nome' => 'Rex',
            'especie' => 'Cachorro',
            'raca' => 'Vira-lata',
            'sexo' => 'Macho',
            'idade' => '2 anos',
            'peso' => 12.5,
            'cor' => 'Caramelo',
            'tutor_id' => 1,
            'status' => 'Castrado',
            'castrado' => true,
            'disponivel_doacao' => false,
            'observacoes' => 'Animal muito dócil.',
            'foto_url' => 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=500',
        ]);

        \App\Models\Animal::create([
            'nome' => 'Mia',
            'especie' => 'Gato',
            'raca' => 'Siamês',
            'sexo' => 'Fêmea',
            'idade' => '1 ano',
            'peso' => 3.2,
            'cor' => 'Bege',
            'tutor_id' => 2,
            'status' => 'Aguardando Castração',
            'castrado' => false,
            'disponivel_doacao' => false,
            'observacoes' => '',
            'foto_url' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=500',
        ]);

        \App\Models\Animal::create([
            'nome' => 'Thor',
            'especie' => 'Cachorro',
            'raca' => 'Golden Retriever',
            'sexo' => 'Macho',
            'idade' => '3 anos',
            'peso' => 28.0,
            'cor' => 'Dourado',
            'tutor_id' => 1,
            'status' => 'Cadastrado',
            'castrado' => false,
            'disponivel_doacao' => false,
            'observacoes' => 'Precisa de vacinas.',
            'foto_url' => 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=500',
        ]);

        \App\Models\Animal::create([
            'nome' => 'Luna',
            'especie' => 'Gato',
            'raca' => 'Persa',
            'sexo' => 'Fêmea',
            'idade' => '4 anos',
            'peso' => 4.5,
            'cor' => 'Branco',
            'tutor_id' => 3,
            'status' => 'Disponível para Doação',
            'castrado' => true,
            'disponivel_doacao' => true,
            'observacoes' => 'Procura um lar tranquilo.',
            'foto_url' => 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=500',
        ]);
        
        // Animals for donation page
        \App\Models\Animal::create([
            'nome' => 'Paçoca',
            'especie' => 'Cachorro',
            'sexo' => 'Macho',
            'idade' => '2 anos',
            'raca' => 'Vira-lata',
            'cor' => 'Caramelo',
            'peso' => 12.5,
            'castrado' => true,
            'foto_url' => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60',
            'observacoes' => 'Muito brincalhão e dócil. Adora crianças.',
            'disponivel_doacao' => true,
            'tutor_id' => 4, // ONG
            'status' => 'Disponível para Doação',
        ]);
    }
}
