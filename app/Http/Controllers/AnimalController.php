<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Tutor;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterEspecie = $request->input('especie', 'all');
        $filterStatus = $request->input('status', 'all');

        $animais = Animal::query()
            ->with(['tutor', 'images'])
            ->when($search, function ($query, $search) {
                $query->where('nome', 'like', "%{$search}%")
                      ->orWhere('raca', 'like', "%{$search}%");
            })
            ->when($filterEspecie !== 'all', function ($query) use ($filterEspecie) {
                $query->where('especie', $filterEspecie);
            })
            ->when($filterStatus !== 'all', function ($query) use ($filterStatus) {
                $query->where('status', $filterStatus);
            })
            ->latest()
            ->get();
            
        $tutores = Tutor::orderBy('nome')->get(['id', 'nome']);

        return view('animais.index', [
            'animais' => $animais,
            'tutores' => $tutores,
            'filters' => [
                'search' => $search,
                'especie' => $filterEspecie,
                'status' => $filterStatus,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'srd' => $request->boolean('srd'),
            'data_nascimento_estimada' => $request->boolean('data_nascimento_estimada'),
            'castrado' => $request->boolean('castrado'),
            'disponivel_doacao' => $request->boolean('disponivel_doacao'),
        ]);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'especie' => 'required|string|max:255',
            'raca' => 'nullable|string|max:255',
            'srd' => 'boolean',
            'idade' => 'nullable|string|max:255',
            'data_nascimento_estimada' => 'boolean',
            'peso' => 'nullable|numeric',
            'porte' => 'nullable|string|in:Pequeno,Médio,Grande',
            'sexo' => 'required|string|max:255',
            'cor' => 'nullable|string|max:255',
            'tutor_id' => 'required|exists:tutors,id',
            'status' => 'required|string|max:255',
            'status_reprodutivo' => 'required|string|in:Inteiro,Castrado,Desconhecido',
            'castrado' => 'boolean',
            'disponivel_doacao' => 'boolean',
            'microchip' => 'nullable|string|unique:animals,microchip',
            'observacoes' => 'nullable|string',
            'photos.*' => 'image|max:5120', // 5MB max
        ]);

        $animal = Animal::create($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('animals', 'public');
                $isPrimary = $index === 0; // First photo is primary by default
                
                $animal->images()->create([
                    'path' => '/storage/' . $path,
                    'is_primary' => $isPrimary
                ]);

                if ($isPrimary) {
                    $animal->update(['foto_url' => '/storage/' . $path]);
                }
            }
        }

        return redirect()->route('animais.index')->with('success', 'Animal cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $animal = Animal::findOrFail($id);

        $request->merge([
            'srd' => $request->boolean('srd'),
            'data_nascimento_estimada' => $request->boolean('data_nascimento_estimada'),
            'castrado' => $request->boolean('castrado'),
            'disponivel_doacao' => $request->boolean('disponivel_doacao'),
        ]);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'especie' => 'required|string|max:255',
            'raca' => 'nullable|string|max:255',
            'srd' => 'boolean',
            'idade' => 'nullable|string|max:255',
            'data_nascimento_estimada' => 'boolean',
            'peso' => 'nullable|numeric',
            'porte' => 'nullable|string|in:Pequeno,Médio,Grande',
            'sexo' => 'required|string|max:255',
            'cor' => 'nullable|string|max:255',
            'tutor_id' => 'required|exists:tutors,id',
            'status' => 'required|string|max:255',
            'status_reprodutivo' => 'required|string|in:Inteiro,Castrado,Desconhecido',
            'castrado' => 'boolean',
            'disponivel_doacao' => 'boolean',
            'microchip' => 'nullable|string|unique:animals,microchip,' . $animal->id,
            'observacoes' => 'nullable|string',
            'photos.*' => 'image|max:5120',
        ]);

        $animal->update($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('animals', 'public');
                
                // If no primary image exists, make this one primary
                $hasPrimary = $animal->images()->where('is_primary', true)->exists();
                $isPrimary = !$hasPrimary;

                $animal->images()->create([
                    'path' => '/storage/' . $path,
                    'is_primary' => $isPrimary
                ]);

                if ($isPrimary) {
                    $animal->update(['foto_url' => '/storage/' . $path]);
                }
            }
        }

        return redirect()->route('animais.index')->with('success', 'Animal atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);
        $animal->delete();

        return redirect()->route('animais.index')->with('success', 'Animal excluído com sucesso!');
    }
}
