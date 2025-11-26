<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimaisDoacaoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterEspecie = $request->input('especie', 'all');
        $filterSexo = $request->input('sexo', 'all');
        $filterPorte = $request->input('porte', 'all');

        $animais = Animal::query()
            ->where('disponivel_doacao', true)
            ->when($search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%")
                      ->orWhere('raca', 'like', "%{$search}%");
                });
            })
            ->when($filterEspecie !== 'all', function ($query) use ($filterEspecie) {
                $query->where('especie', $filterEspecie);
            })
            ->when($filterSexo !== 'all', function ($query) use ($filterSexo) {
                $query->where('sexo', $filterSexo);
            })
            ->when($filterPorte !== 'all', function ($query) use ($filterPorte) {
                $query->where('porte', $filterPorte);
            })
            ->latest()
            ->paginate(12);

        return view('animais-doacao.index', [
            'animais' => $animais,
            'filters' => [
                'search' => $search,
                'especie' => $filterEspecie,
                'sexo' => $filterSexo,
                'porte' => $filterPorte,
            ]
        ]);
    }
}
