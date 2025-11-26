<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $tutores = Tutor::query()
            ->when($search, function ($query, $search) {
                $query->where('nome', 'like', "%{$search}%")
                      ->orWhere('cpf', 'like', "%{$search}%")
                      ->orWhere('telefone', 'like', "%{$search}%");
            })
            ->withCount('animais')
            ->latest()
            ->get();

        return view('tutores.index', [
            'tutores' => $tutores,
            'search' => $search
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|in:Tutor,Lar Temporário',
            'telefone' => 'required|string|max:20',
            'cpf' => 'required|string|unique:tutors,cpf',
            'email' => 'nullable|email|max:255',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cep' => 'required|string|max:20',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|max:2',
            'observacoes' => 'nullable|string',
        ]);

        try {
            Tutor::create($validated);
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return back()
                ->withInput()
                ->withErrors(['cpf' => 'Este CPF já está cadastrado.']);
        }

        return redirect()->route('tutores.index')->with('success', 'Tutor cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $tutor = Tutor::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|in:Tutor,Lar Temporário',
            'telefone' => 'required|string|max:20',
            'cpf' => 'required|string|unique:tutors,cpf,' . $tutor->id,
            'email' => 'nullable|email|max:255',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cep' => 'required|string|max:20',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|max:2',
            'observacoes' => 'nullable|string',
        ]);

        try {
            $tutor->update($validated);
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return back()
                ->withInput()
                ->withErrors(['cpf' => 'Este CPF já está cadastrado.']);
        }

        return redirect()->route('tutores.index')->with('success', 'Tutor atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $tutor = Tutor::findOrFail($id);
        $tutor->delete();

        return redirect()->route('tutores.index')->with('success', 'Tutor excluído com sucesso!');
    }
}
