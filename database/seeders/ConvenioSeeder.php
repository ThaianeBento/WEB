<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConvenioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Convenio::create([
            'nome' => 'Clínica Veterinária Pet Feliz',
            'tipo' => 'Clínica Veterinária',
            'responsavel' => 'Dr. Carlos',
            'telefone' => '(11) 3333-4444',
            'email' => 'contato@petfeliz.com',
            'endereco' => 'Rua dos Animais, 100',
            'cidade' => 'São Paulo',
            'uf' => 'SP',
            'valor_castracao_cachorro' => 150.00,
            'valor_castracao_gato' => 100.00,
            'ativo' => true,
            'observacoes' => 'Atendimento 24h',
        ]);

        \App\Models\Convenio::create([
            'nome' => 'Hospital Vet Care',
            'tipo' => 'Hospital',
            'responsavel' => 'Dra. Ana',
            'telefone' => '(11) 5555-6666',
            'email' => 'atendimento@vetcare.com',
            'endereco' => 'Av. da Saúde, 500',
            'cidade' => 'Campinas',
            'uf' => 'SP',
            'valor_castracao_cachorro' => 180.00,
            'valor_castracao_gato' => 120.00,
            'ativo' => true,
            'observacoes' => '',
        ]);

        \App\Models\Convenio::create([
            'nome' => 'ONG Amigos dos Bichos',
            'tipo' => 'ONG',
            'responsavel' => 'Maria',
            'telefone' => '(11) 7777-8888',
            'email' => 'ong@amigosdosbichos.org',
            'endereco' => 'Rua da Esperança, 20',
            'cidade' => 'Santos',
            'uf' => 'SP',
            'valor_castracao_cachorro' => 80.00,
            'valor_castracao_gato' => 50.00,
            'ativo' => false,
            'observacoes' => 'Parceria em renovação',
        ]);

        // Add Price Rules
        $convenios = \App\Models\Convenio::all();

        foreach ($convenios as $convenio) {
            // Dog Castration
            $convenio->precos()->create([
                'descricao' => 'Castração Canina (Pequeno Porte)',
                'especie' => 'Canino',
                'peso_min' => 0,
                'peso_max' => 10,
                'valor' => $convenio->valor_castracao_cachorro ?? 150.00,
            ]);

            $convenio->precos()->create([
                'descricao' => 'Castração Canina (Médio Porte)',
                'especie' => 'Canino',
                'peso_min' => 10.1,
                'peso_max' => 25,
                'valor' => ($convenio->valor_castracao_cachorro ?? 150.00) * 1.2,
            ]);

            // Cat Castration
            $convenio->precos()->create([
                'descricao' => 'Castração Felina (Geral)',
                'especie' => 'Felino',
                'peso_min' => 0,
                'peso_max' => 10,
                'valor' => $convenio->valor_castracao_gato ?? 100.00,
            ]);
        }
    }
}
