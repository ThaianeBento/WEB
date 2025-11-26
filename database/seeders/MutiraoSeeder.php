<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mutirao;
use App\Models\Veterinario;

class MutiraoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have some veterinarians
        // Ensure we have some veterinarians
        if (Veterinario::count() == 0) {
            $vets = [
                ['nome' => 'Dr. Silva', 'cpf' => '111.111.111-11', 'crmv' => '12345-SP', 'especialidade' => 'Cirurgia', 'telefone' => '11999999999', 'email' => 'silva@email.com', 'endereco' => 'Rua A, 1', 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'uf' => 'SP', 'cep' => '01000-000'],
                ['nome' => 'Dra. Santos', 'cpf' => '222.222.222-22', 'crmv' => '67890-SP', 'especialidade' => 'Anestesia', 'telefone' => '11888888888', 'email' => 'santos@email.com', 'endereco' => 'Rua B, 2', 'bairro' => 'Bela Vista', 'cidade' => 'São Paulo', 'uf' => 'SP', 'cep' => '01300-000'],
                ['nome' => 'Dr. Oliveira', 'cpf' => '333.333.333-33', 'crmv' => '11223-SP', 'especialidade' => 'Clínica Geral', 'telefone' => '11777777777', 'email' => 'oliveira@email.com', 'endereco' => 'Rua C, 3', 'bairro' => 'Pinheiros', 'cidade' => 'São Paulo', 'uf' => 'SP', 'cep' => '05400-000'],
            ];
            foreach ($vets as $vet) {
                Veterinario::firstOrCreate(
                    ['cpf' => $vet['cpf']],
                    $vet
                );
            }
        }

        $vets = Veterinario::all();

        // Mutirão 1: Past (Concluído)
        $mutirao1 = Mutirao::create([
            'nome' => 'Mutirão Zona Norte',
            'data' => '2023-11-25',
            'local' => 'Centro Comunitário ZN',
            'capacidade' => 50,
            'status' => 'Concluído',
            'observacoes' => 'Sucesso total.'
        ]);
        
        // Attach Team
        $mutirao1->veterinarios()->attach($vets[0]->id, ['funcao' => 'Cirurgião']);
        $mutirao1->veterinarios()->attach($vets[1]->id, ['funcao' => 'Anestesista']);

        // Mutirão 2: Future (Aberto)
        $mutirao2 = Mutirao::create([
            'nome' => 'Mutirão Zona Sul',
            'data' => '2024-12-10',
            'local' => 'Escola Estadual ZS',
            'capacidade' => 60,
            'status' => 'Aberto',
            'observacoes' => 'Inscrições abertas.'
        ]);

        $mutirao2->veterinarios()->attach($vets[0]->id, ['funcao' => 'Cirurgião']);
        $mutirao2->veterinarios()->attach($vets[2]->id, ['funcao' => 'Auxiliar']);

        // Mutirão 3: Future (Planejado)
        Mutirao::create([
            'nome' => 'Mutirão Centro',
            'data' => '2025-01-15',
            'local' => 'Ginásio Central',
            'capacidade' => 80,
            'status' => 'Planejado',
            'observacoes' => 'Aguardando confirmação de local.'
        ]);
    }
}
