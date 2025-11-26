<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Animal;
use App\Models\Convenio;
use App\Models\Mutirao;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $mutiraoId = $request->input('mutirao_id');
        $status = $request->input('status', 'all');

        $agendamentos = Agendamento::query()
            ->with(['animal', 'tutor', 'convenio', 'mutirao'])
            ->when($search, function ($query, $search) {
                $query->whereHas('animal', function ($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%");
                })->orWhereHas('tutor', function ($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%");
                });
            })
            ->when($mutiraoId, function ($query, $mutiraoId) {
                $query->where('mutirao_id', $mutiraoId);
            })
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest('data_agendamento')
            ->get();

        $animais = Animal::orderBy('nome')->get();
        $tutores = Tutor::orderBy('nome')->get();
        $convenios = Convenio::with('precos')->orderBy('nome')->get();
        $mutiroes = Mutirao::where('status', '!=', 'Cancelado')->orderBy('data')->get();

        return view('agenda.index', [
            'agendamentos' => $agendamentos,
            'animais' => $animais,
            'tutores' => $tutores,
            'convenios' => $convenios,
            'mutiroes' => $mutiroes,
            'search' => $search,
            'selectedMutiraoId' => $mutiraoId,
            'filters' => ['status' => $status]
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'data_agendamento' => 'required|date',
                'horario' => 'required',
                'valor' => 'required|numeric',
                'status' => 'required|string',
                'observacoes' => 'nullable|string',
                'animal_id' => 'required|exists:animals,id',
                'tutor_id' => 'nullable|exists:tutors,id',
                'convenio_id' => 'nullable|exists:convenios,id',
                'mutirao_id' => 'nullable|exists:mutiraos,id',
            ]);

            // Auto-fill tutor_id if not provided
            if (empty($validated['tutor_id'])) {
                $animal = Animal::find($validated['animal_id']);
                if ($animal && $animal->tutor_id) {
                    $validated['tutor_id'] = $animal->tutor_id;
                }
            }

            Agendamento::create($validated);

            return redirect()->route('agenda.index')->with('success', 'Agendamento criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar agendamento: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erro ao criar agendamento: ' . $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $agendamento = Agendamento::findOrFail($id);

            $validated = $request->validate([
                'data_agendamento' => 'sometimes|required|date',
                'horario' => 'sometimes|required',
                'valor' => 'sometimes|required|numeric',
                'status' => 'required|string',
                'observacoes' => 'nullable|string',
                'animal_id' => 'sometimes|required|exists:animals,id',
                'tutor_id' => 'nullable|exists:tutors,id',
                'convenio_id' => 'nullable|exists:convenios,id',
                'mutirao_id' => 'nullable|exists:mutiraos,id',
            ]);

            // Auto-fill tutor_id if not provided but animal_id is present
            if (empty($validated['tutor_id']) && !empty($validated['animal_id'])) {
                $animal = Animal::find($validated['animal_id']);
                if ($animal && $animal->tutor_id) {
                    $validated['tutor_id'] = $animal->tutor_id;
                }
            }

            $agendamento->update($validated);

            // Update animal status if agenda is 'Realizado'
            if (isset($validated['status']) && $validated['status'] === 'Realizado' && $agendamento->animal) {
                $agendamento->animal->update([
                    'status' => 'Castrado',
                    'status_reprodutivo' => 'Castrado',
                    'castrado' => true
                ]);
            }

            return redirect()->route('agenda.index')->with('success', 'Agendamento atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar agendamento: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erro ao atualizar agendamento: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $agendamento = Agendamento::findOrFail($id);
            $agendamento->delete();

            return redirect()->route('agenda.index')->with('success', 'Agendamento excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir agendamento: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erro ao excluir agendamento.']);
        }
    }

    public function checkIn(Request $request, $id)
    {
        try {
            $agendamento = Agendamento::findOrFail($id);

            $validated = $request->validate([
                'peso_medido' => 'required|numeric|min:0',
                'jejum_ok' => 'accepted',
            ]);

            $agendamento->update([
                'peso_medido' => $validated['peso_medido'],
                'jejum_ok' => true,
                'status' => 'Triagem'
            ]);

            // Update animal's weight
            if ($agendamento->animal) {
                $agendamento->animal->update(['peso' => $validated['peso_medido']]);
            }

            return redirect()->route('agenda.index')->with('success', 'Check-in realizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao realizar check-in: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erro ao realizar check-in: ' . $e->getMessage()]);
        }
    }
}
