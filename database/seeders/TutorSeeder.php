<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Tutor::firstOrCreate(
            ['cpf' => '123.456.789-00'],
            [
                'nome' => 'João Silva',
                'telefone' => '(11) 98765-4321',
                'email' => 'joao@email.com',
                'endereco' => 'Rua das Flores, 123',
                'bairro' => 'Jardim Primavera',
                'cep' => '01234-567',
                'observacoes' => 'Disponível aos finais de semana.',
            ]
        );

        \App\Models\Tutor::firstOrCreate(
            ['cpf' => '234.567.890-11'],
            [
                'nome' => 'Maria Oliveira',
                'telefone' => '(11) 91234-5678',
                'email' => 'maria@email.com',
                'endereco' => 'Av. Paulista, 1000',
                'bairro' => 'Bela Vista',
                'cep' => '13000-000',
                'observacoes' => '',
            ]
        );

        \App\Models\Tutor::firstOrCreate(
            ['cpf' => '345.678.901-22'],
            [
                'nome' => 'Pedro Santos',
                'telefone' => '(11) 99876-5432',
                'email' => 'pedro@email.com',
                'endereco' => 'Rua do Porto, 50',
                'bairro' => 'Centro',
                'cep' => '11000-000',
                'observacoes' => 'Prefere contato por WhatsApp.',
            ]
        );
        
        \App\Models\Tutor::firstOrCreate(
            ['cpf' => '000.000.000-00'],
            [
                'nome' => 'ONG Mutirão Amigo',
                'telefone' => '(11) 3333-3333',
                'email' => 'contato@mutiraoamigo.org',
                'endereco' => 'Sede da ONG',
                'bairro' => 'Centro',
                'cep' => '00000-000',
                'observacoes' => 'Tutor institucional.',
            ]
        );
    }
}
