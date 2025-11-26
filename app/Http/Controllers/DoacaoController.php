<?php

namespace App\Http\Controllers;

use App\Models\Doacao;
use App\Models\Animal;
use Illuminate\Http\Request;

class DoacaoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        // Doacao model doesn't have a status field in migration, but Animal has.
        // Or maybe we should infer status from 'data_doacao' (if null => available?)
        // The mock data had 'status'. The migration has 'data_doacao', 'adotante_nome', etc.
        // Let's assume for now we list donations that happened.
        // Or maybe this controller manages the *records* of donations.
        // If we want to manage "Available for adoption", that's usually on the Animal model (disponivel_doacao=true).
        // The `Doacao` model seems to represent a *completed* or *processed* donation event.
        
        // Let's list all Doacao records.
        
        $doacoes = Doacao::query()
            ->with('animal')
            ->when($search, function ($query, $search) {
                $query->whereHas('animal', function ($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%");
                })->orWhere('adotante_nome', 'like', "%{$search}%");
            })
            ->latest('data_doacao')
            ->get();
            
        // For the form, we might need animals that are available for adoption?
        // Or animals that are being donated.
        $animais = Animal::where('disponivel_doacao', true)->orderBy('nome')->get();

        return view('doacoes.index', [
            'doacoes' => $doacoes,
            'animais' => $animais,
            'filters' => [
                'search' => $search,
                'status' => 'all', // Kept for view compatibility if needed, though logic might change
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'data_doacao' => 'required|date',
            'adotante_nome' => 'required|string|max:255',
            'adotante_contato' => 'required|string|max:255',
            'observacoes' => 'nullable|string',
        ]);

        $doacao = Doacao::create($validated);
        
        // Update animal status
        $animal = Animal::find($validated['animal_id']);
        $animal->disponivel_doacao = false;
        $animal->status = 'Adotado';
        $animal->save();

        return redirect()->route('doacoes.index')->with('success', 'Doação registrada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $doacao = Doacao::findOrFail($id);

        $validated = $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'data_doacao' => 'required|date',
            'adotante_nome' => 'required|string|max:255',
            'adotante_contato' => 'required|string|max:255',
            'observacoes' => 'nullable|string',
        ]);

        $doacao->update($validated);

        return redirect()->route('doacoes.index')->with('success', 'Doação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $doacao = Doacao::findOrFail($id);
        
        // Revert animal status? Maybe.
        // For now, let's just delete the record.
        
        $doacao->delete();

        return redirect()->route('doacoes.index')->with('success', 'Doação excluída com sucesso!');
    }
}
