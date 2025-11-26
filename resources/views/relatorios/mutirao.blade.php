@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 p-6">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 no-print">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Relatório do Mutirão</h1>
                <p class="text-slate-500">{{ $mutirao->nome }} - {{ \Carbon\Carbon::parse($mutirao->data)->format('d/m/Y') }}</p>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 shadow-sm">
                    <x-icon name="Printer" class="w-4 h-4 mr-2" />
                    Imprimir
                </button>
                <a href="{{ route('mutiroes.index') }}" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-slate-900 text-white hover:bg-slate-800 shadow-sm">
                    Voltar
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Agendamentos</p>
                <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['total_agendamentos'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Confirmados/Realizados</p>
                <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $stats['total_confirmados'] + $stats['total_realizados'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Cancelados</p>
                <p class="text-3xl font-bold text-red-600 mt-2">{{ $stats['total_cancelados'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Valor Total Estimado</p>
                <p class="text-3xl font-bold text-indigo-600 mt-2">R$ {{ number_format($stats['valor_total'], 2, ',', '.') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- Species Chart --}}
            <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Por Espécie</h3>
                <div class="space-y-4">
                    @foreach($stats['por_especie'] as $especie => $count)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-slate-700">{{ $especie }}</span>
                                <span class="text-slate-500">{{ $count }} ({{ number_format(($count / $stats['total_agendamentos']) * 100, 1) }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5">
                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($count / $stats['total_agendamentos']) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Gender Chart --}}
            <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Por Sexo</h3>
                <div class="space-y-4">
                    @foreach($stats['por_genero'] as $sexo => $count)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-slate-700">{{ $sexo }}</span>
                                <span class="text-slate-500">{{ $count }} ({{ number_format(($count / $stats['total_agendamentos']) * 100, 1) }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5">
                                <div class="bg-rose-500 h-2.5 rounded-full" style="width: {{ ($count / $stats['total_agendamentos']) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Detailed List --}}
        <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-lg font-semibold">Lista Detalhada</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 font-medium border-b">
                        <tr>
                            <th class="px-6 py-3">Animal</th>
                            <th class="px-6 py-3">Espécie</th>
                            <th class="px-6 py-3">Tutor</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Valor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($mutirao->agendamentos as $agendamento)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-3 font-medium text-slate-900">{{ $agendamento->animal->nome }}</td>
                                <td class="px-6 py-3">{{ $agendamento->animal->especie }}</td>
                                <td class="px-6 py-3">{{ $agendamento->tutor->nome }}</td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ $agendamento->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-right">R$ {{ number_format($agendamento->valor, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white; }
        .shadow-sm { box-shadow: none !important; border: 1px solid #e2e8f0; }
    }
</style>
@endsection
