<?php

namespace App\Http\Controllers;

use App\Models\Veterinario;
use Illuminate\Http\Request;

class VeterinarioController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $veterinarios = Veterinario::query()
            ->when($search, function ($query, $search) {
                $query->where('nome', 'like', "%{$search}%")
                      ->orWhere('cpf', 'like', "%{$search}%")
                      ->orWhere('crmv', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('veterinarios.index', [
            'veterinarios' => $veterinarios,
            'search' => $search
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|unique:veterinarios,cpf',
            'crmv' => 'nullable|string|max:20',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|size:2',
            'cep' => 'required|string|max:20',
        ]);

        Veterinario::create($validated);

        return redirect()->route('veterinarios.index')->with('success', 'Veterinário cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $veterinario = Veterinario::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|unique:veterinarios,cpf,' . $veterinario->id,
            'crmv' => 'nullable|string|max:20',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|size:2',
            'cep' => 'required|string|max:20',
        ]);

        $veterinario->update($validated);

        return redirect()->route('veterinarios.index')->with('success', 'Veterinário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $veterinario = Veterinario::findOrFail($id);
        $veterinario->delete();

        return redirect()->route('veterinarios.index')->with('success', 'Veterinário excluído com sucesso!');
    }
}
