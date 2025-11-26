<?php

namespace App\Http\Controllers;

use App\Models\Mutirao;
use App\Models\Veterinario;
use Illuminate\Http\Request;

class MutiraoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $mutiroes = Mutirao::query()
            ->with('veterinarios')
            ->when($search, function ($query, $search) {
                $query->where('nome', 'like', "%{$search}%")
                      ->orWhere('local', 'like', "%{$search}%");
            })
            ->latest('data')
            ->get();

        $veterinarios = Veterinario::orderBy('nome')->get();

        return view('mutiroes.index', [
            'mutiroes' => $mutiroes,
            'veterinarios' => $veterinarios,
            'search' => $search
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'data' => 'required|date',
            'local' => 'required|string|max:255',
            'capacidade' => 'required|integer|min:1',
            'status' => 'required|string|in:Planejado,Aberto,Concluído,Cancelado',
            'observacoes' => 'nullable|string',
        ]);

        Mutirao::create($validated);

        return redirect()->route('mutiroes.index')->with('success', 'Mutirão criado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $mutirao = Mutirao::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'data' => 'required|date',
            'local' => 'required|string|max:255',
            'capacidade' => 'required|integer|min:1',
            'status' => 'required|string|in:Planejado,Aberto,Concluído,Cancelado',
            'observacoes' => 'nullable|string',
        ]);

        $mutirao->update($validated);

        return redirect()->route('mutiroes.index')->with('success', 'Mutirão atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $mutirao = Mutirao::findOrFail($id);
        $mutirao->delete();

        return redirect()->route('mutiroes.index')->with('success', 'Mutirão excluído com sucesso!');
    }

    public function addVeterinario(Request $request, $id)
    {
        $mutirao = Mutirao::findOrFail($id);
        
        $validated = $request->validate([
            'veterinario_id' => 'required|exists:veterinarios,id',
            'funcao' => 'required|string|max:255',
        ]);

        // Check if already attached
        if (!$mutirao->veterinarios()->where('veterinario_id', $validated['veterinario_id'])->exists()) {
            $mutirao->veterinarios()->attach($validated['veterinario_id'], ['funcao' => $validated['funcao']]);
            return back()->with('success', 'Veterinário adicionado à equipe!');
        }

        return back()->with('error', 'Veterinário já está na equipe deste mutirão.');
    }

    public function removeVeterinario($id, $veterinarioId)
    {
        $mutirao = Mutirao::findOrFail($id);
        $mutirao->veterinarios()->detach($veterinarioId);

        return back()->with('success', 'Veterinário removido da equipe.');
    }
}
