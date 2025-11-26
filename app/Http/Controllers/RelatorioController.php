<?php

namespace App\Http\Controllers;

use App\Models\Mutirao;
use App\Models\Convenio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RelatorioController extends Controller
{
    public function mutirao($id)
    {
        $mutirao = Mutirao::with(['agendamentos.animal', 'agendamentos.tutor', 'agendamentos.convenio'])->findOrFail($id);

        $stats = [
            'total_agendamentos' => $mutirao->agendamentos->count(),
            'total_confirmados' => $mutirao->agendamentos->where('status', 'Confirmado')->count(),
            'total_realizados' => $mutirao->agendamentos->whereIn('status', ['Realizado', 'Triagem', 'Em Cirurgia', 'Recuperação'])->count(),
            'total_cancelados' => $mutirao->agendamentos->where('status', 'Cancelado')->count(),
            'por_especie' => $mutirao->agendamentos->groupBy('animal.especie')->map->count(),
            'por_genero' => $mutirao->agendamentos->groupBy('animal.sexo')->map->count(),
            'valor_total' => $mutirao->agendamentos->sum('valor'),
        ];

        return view('relatorios.mutirao', compact('mutirao', 'stats'));
    }

    public function exportConvenios()
    {
        $convenios = Convenio::with('precos')->get();

        $csvFileName = 'convenios_' . date('Y-m-d_H-i') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($convenios) {
            $file = fopen('php://output', 'w');
            
            // Header Row
            fputcsv($file, ['ID', 'Nome', 'Tipo', 'Contato', 'Email', 'Cidade', 'Status', 'Regras de Preco']);

            foreach ($convenios as $convenio) {
                $regras = $convenio->precos->map(function($preco) {
                    return "{$preco->descricao} ({$preco->especie}): R$ {$preco->valor}";
                })->implode(' | ');

                fputcsv($file, [
                    $convenio->id,
                    $convenio->nome,
                    $convenio->tipo,
                    $convenio->telefone,
                    $convenio->email,
                    $convenio->cidade,
                    $convenio->ativo ? 'Ativo' : 'Inativo',
                    $regras
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
