<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\Preco;
use Illuminate\Http\Request;

class ConvenioController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $convenios = Convenio::query()
            ->with('precos')
            ->when($search, function ($query, $search) {
                $query->where('nome', 'like', "%{$search}%")
                      ->orWhere('cidade', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('convenios.index', [
            'convenios' => $convenios,
            'search' => $search
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'responsavel' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf' => 'nullable|string|max:2',
            'valor_castracao_cachorro' => 'nullable|numeric',
            'valor_castracao_gato' => 'nullable|numeric',
            'ativo' => 'boolean',
            'observacoes' => 'nullable|string',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date',
            'termos' => 'nullable|string',
        ]);

        $validated['ativo'] = $request->has('ativo');

        Convenio::create($validated);

        return redirect()->route('convenios.index')->with('success', 'Convênio cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $convenio = Convenio::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'responsavel' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf' => 'nullable|string|max:2',
            'valor_castracao_cachorro' => 'nullable|numeric',
            'valor_castracao_gato' => 'nullable|numeric',
            'ativo' => 'boolean',
            'observacoes' => 'nullable|string',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date',
            'termos' => 'nullable|string',
        ]);

        $validated['ativo'] = $request->has('ativo');

        $convenio->update($validated);

        return redirect()->route('convenios.index')->with('success', 'Convênio atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $convenio = Convenio::findOrFail($id);
        $convenio->delete();

        return redirect()->route('convenios.index')->with('success', 'Convênio excluído com sucesso!');
    }

    public function addPreco(Request $request, $id)
    {
        $convenio = Convenio::findOrFail($id);

        $validated = $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'especie' => 'nullable|string|in:Canino,Felino',
            'peso_min' => 'nullable|numeric|min:0',
            'peso_max' => 'nullable|numeric|min:0',
        ]);

        // Validation Logic
        $existingPrecos = $convenio->precos;
        $newEspecie = $validated['especie'] ?? null;

        // Rule: If adding "Any Species" (null), no other prices can exist
        if (is_null($newEspecie)) {
            if ($existingPrecos->count() > 0) {
                return back()->withErrors(['error' => 'Não é possível adicionar uma regra para "Qualquer espécie" se já existem outras regras cadastradas. Remova as existentes primeiro.']);
            }
        } else {
            // Rule: If adding specific species, "Any Species" cannot exist
            $hasGeneric = $existingPrecos->whereNull('especie')->count() > 0;
            if ($hasGeneric) {
                return back()->withErrors(['error' => 'Não é possível adicionar uma regra específica se já existe uma regra para "Qualquer espécie". Remova a regra genérica primeiro.']);
            }

            // Rule: Cannot duplicate species
            $hasSpecific = $existingPrecos->where('especie', $newEspecie)->count() > 0;
            if ($hasSpecific) {
                return back()->withErrors(['error' => "Já existe uma tabela de preço para a espécie {$newEspecie}."]);
            }
        }

        $convenio->precos()->create($validated);

        return back()->with('success', 'Regra de preço adicionada com sucesso!');
    }

    public function removePreco($id, $precoId)
    {
        $convenio = Convenio::findOrFail($id);
        $convenio->precos()->findOrFail($precoId)->delete();

        return back()->with('success', 'Regra de preço removida com sucesso!');
    }
}
