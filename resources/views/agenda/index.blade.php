<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda - Mutirão Amigo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 2rem;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
        }
        .btn-back {
            background-color: #e5e7eb;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        .btn-back:hover {
            background-color: #d1d5db;
        }
        /* Custom scrollbar for modal */
        .overflow-y-auto::-webkit-scrollbar {
            width: 8px;
        }
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <div class="container" x-data="{ 
        formOpen: {{ $errors->any() ? 'true' : 'false' }}, 
        deleteModalOpen: false, 
        selectedAgendamento: null,
        deleteId: null,
        
        checkInModalOpen: false,
        checkInId: null,
        checkInAnimal: null,
        checkInWeight: '',

        // Data for auto-fill
        convenios: {{ json_encode($convenios) }},
        animais: {{ json_encode($animais) }},
        
        openForm(agendamento = null) {
            if (agendamento) {
                this.selectedAgendamento = {...agendamento};
                // Format date to YYYY-MM-DD
                if (this.selectedAgendamento.data_agendamento) {
                    this.selectedAgendamento.data_agendamento = this.selectedAgendamento.data_agendamento.split('T')[0];
                }
                // Format time to HH:MM (remove seconds if present)
                if (this.selectedAgendamento.horario) {
                    this.selectedAgendamento.horario = this.selectedAgendamento.horario.substring(0, 5);
                }
            } else {
                this.selectedAgendamento = {
                    data_agendamento: '',
                    horario: '',
                    animal_id: '',
                    tutor_id: '',
                    convenio_id: '',
                    mutirao_id: '',
                    valor: '',
                    status: 'Agendado'
                };
            }
            this.formOpen = true;
        },

        updatePrice() {
            if (!this.selectedAgendamento.convenio_id || !this.selectedAgendamento.animal_id) {
                return;
            }

            const convenio = this.convenios.find(c => c.id == this.selectedAgendamento.convenio_id);
            const animal = this.animais.find(a => a.id == this.selectedAgendamento.animal_id);

            if (convenio && animal && convenio.precos && convenio.precos.length > 0) {
                // 1. Try to find specific species price
                let priceRule = convenio.precos.find(p => p.especie === animal.especie);

                // 2. If not found, try to find generic price (null species)
                if (!priceRule) {
                    priceRule = convenio.precos.find(p => p.especie === null);
                }

                if (priceRule) {
                    this.selectedAgendamento.valor = priceRule.valor;
                }
            }
        },

        confirmDelete(id) {
            this.deleteId = id;
            this.deleteModalOpen = true;
        },

        openCheckIn(agendamento) {
            this.checkInId = agendamento.id;
            this.checkInAnimal = agendamento.animal_nome;
            this.checkInWeight = agendamento.animal?.peso || '';
            this.checkInModalOpen = true;
        },

        formatCurrency(value) {
            if (!value) return '-';
            return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
        }
     }">
        <div class="header">
            <h1 class="title">Agenda de Castrações</h1>
            <div class="flex gap-4">
                <button @click="openForm()" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-amber-600 text-white hover:bg-amber-700 shadow-sm">
                    <x-icon name="Scissors" class="w-4 h-4 mr-2" />
                    Novo Agendamento
                </button>
                <a href="{{ route('internal.dashboard') }}" class="btn-back">Voltar para Painel</a>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-6">
            <form action="{{ route('agenda.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <x-icon name="Search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search }}"
                        placeholder="Buscar por animal ou tutor..." 
                        class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 pl-10 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-600 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                </div>
                <select name="mutirao_id" onchange="this.form.submit()" class="flex h-10 w-48 items-center justify-between rounded-md border border-slate-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="">Todos Mutirões</option>
                    @foreach($mutiroes as $mutirao)
                        <option value="{{ $mutirao->id }}" {{ $selectedMutiraoId == $mutirao->id ? 'selected' : '' }}>
                            {{ $mutirao->nome }} ({{ \Carbon\Carbon::parse($mutirao->data)->format('d/m') }})
                        </option>
                    @endforeach
                </select>
                <select name="status" onchange="this.form.submit()" class="flex h-10 w-48 items-center justify-between rounded-md border border-slate-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="all" {{ $filters['status'] === 'all' ? 'selected' : '' }}>Todos Status</option>
                    <option value="Agendado" {{ $filters['status'] === 'Agendado' ? 'selected' : '' }}>Agendado</option>
                    <option value="Confirmado" {{ $filters['status'] === 'Confirmado' ? 'selected' : '' }}>Confirmado</option>
                    <option value="Realizado" {{ $filters['status'] === 'Realizado' ? 'selected' : '' }}>Realizado</option>
                    <option value="Cancelado" {{ $filters['status'] === 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                    <option value="Não Compareceu" {{ $filters['status'] === 'Não Compareceu' ? 'selected' : '' }}>Não Compareceu</option>
                </select>
            </form>
        </div>

        {{-- Content --}}
        @if(count($agendamentos) === 0)
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-12 text-center">
                <div class="flex flex-col items-center justify-center gap-4">
                    <div class="p-4 bg-slate-50 rounded-full">
                        <x-icon name="Calendar" class="w-8 h-8 text-slate-400" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Nenhum agendamento encontrado</h3>
                        <p class="text-slate-500 mt-1">Agende a primeira castração</p>
                    </div>
                    <button @click="openForm()" class="inline-flex items-center justify-center h-9 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-amber-600 text-white hover:bg-amber-700 shadow-sm mt-2">
                        Novo Agendamento
                    </button>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-slate-50/50 data-[state=selected]:bg-slate-50 bg-slate-50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Data</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Animal</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Tutor</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Convênio</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Valor</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Status</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 w-12"></th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @foreach($agendamentos as $agendamento)
                                <tr class="border-b transition-colors hover:bg-slate-50/50 data-[state=selected]:bg-slate-50">
                                    <td class="p-4 align-middle">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                                                <x-icon name="Calendar" class="w-5 h-5 text-amber-600" />
                                            </div>
                                            <div>
                                                <span class="font-medium block">
                                                    {{ \Carbon\Carbon::parse($agendamento['data_agendamento'])->format('d/m/Y') }}
                                                </span>
                                                @if(!empty($agendamento['horario']))
                                                    <span class="text-sm text-slate-500">{{ $agendamento['horario'] }}</span>
                                                @endif
                                                @if($agendamento['mutirao'])
                                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-800 mt-1">
                                                        {{ $agendamento['mutirao']['nome'] }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle font-medium">{{ $agendamento['animal_nome'] }}</td>
                                    <td class="p-4 align-middle">{{ $agendamento['tutor_nome'] ?? '-' }}</td>
                                    <td class="p-4 align-middle">{{ $agendamento['convenio_nome'] ?? '-' }}</td>
                                    <td class="p-4 align-middle">
                                        R$ {{ number_format($agendamento['valor'], 2, ',', '.') }}
                                    </td>
                                    <td class="p-4 align-middle">
                                        @php
                                            $statusColors = [
                                                "Agendado" => "bg-blue-100 text-blue-700",
                                                "Confirmado" => "bg-emerald-100 text-emerald-700",
                                                "Realizado" => "bg-green-100 text-green-700",
                                                "Cancelado" => "bg-red-100 text-red-700",
                                                "Não Compareceu" => "bg-amber-100 text-amber-700"
                                            ];
                                            $colorClass = $statusColors[$agendamento['status']] ?? "bg-slate-100 text-slate-700";
                                        @endphp
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent {{ $colorClass }}">
                                            {{ $agendamento['status'] }}
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-slate-100 h-8 w-8">
                                                <x-icon name="Scissors" class="w-4 h-4 rotate-90" />
                                            </button>
                                            <div x-show="open" x-transition class="absolute right-0 z-50 mt-2 w-48 rounded-md border border-slate-200 bg-white p-1 shadow-md">
                                                <button 
                                                    data-agendamento="{{ json_encode($agendamento) }}"
                                                    @click="openForm(JSON.parse($el.dataset.agendamento)); open = false" 
                                                    class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-slate-100 focus:bg-slate-100"
                                                >
                                                    <x-icon name="Scissors" class="w-4 h-4 mr-2" /> Editar
                                                </button>
                                                
                                                {{-- Status Actions --}}
                                                @if($agendamento['status'] === 'Agendado')
                                                    <form method="POST" action="{{ route('agenda.update', $agendamento['id']) }}">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="Confirmado">
                                                        <button type="submit" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-slate-100 focus:bg-slate-100 text-emerald-600">
                                                            <x-icon name="ArrowRight" class="w-4 h-4 mr-2" /> Confirmar
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($agendamento['status'] === 'Confirmado')
                                                    <button 
                                                        data-agendamento="{{ json_encode($agendamento) }}"
                                                        @click="openCheckIn(JSON.parse($el.dataset.agendamento)); open = false" 
                                                        class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-slate-100 focus:bg-slate-100 text-indigo-600"
                                                    >
                                                        <x-icon name="ClipboardCheck" class="w-4 h-4 mr-2" /> Check-in
                                                    </button>
                                                @endif

                                                @if(in_array($agendamento['status'], ['Agendado', 'Confirmado']))
                                                    <form method="POST" action="{{ route('agenda.update', $agendamento['id']) }}">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="Realizado">
                                                        <button type="submit" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-slate-100 focus:bg-slate-100 text-green-600">
                                                            <x-icon name="ArrowRight" class="w-4 h-4 mr-2" /> Realizado
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('agenda.update', $agendamento['id']) }}">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="Cancelado">
                                                        <button type="submit" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-slate-100 focus:bg-slate-100 text-red-600">
                                                            <x-icon name="ArrowRight" class="w-4 h-4 mr-2" /> Cancelar
                                                        </button>
                                                    </form>
                                                @endif

                                                <div class="h-px bg-slate-200 my-1"></div>
                                                <button @click="confirmDelete({{ $agendamento['id'] }}); open = false" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 text-red-600 focus:bg-red-50">
                                                    <x-icon name="Scissors" class="w-4 h-4 mr-2" /> Excluir
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Form Modal --}}
        <div x-show="formOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-transition>
            <div class="bg-white rounded-xl shadow-lg w-full max-w-lg mx-4 overflow-hidden max-h-[90vh] overflow-y-auto" @click.outside="formOpen = false">
                <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
                    <h2 class="text-lg font-semibold" x-text="selectedAgendamento?.id ? 'Editar Agendamento' : 'Novo Agendamento'"></h2>
                    <button @click="formOpen = false" class="text-slate-400 hover:text-slate-500">
                        <span class="sr-only">Fechar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form method="POST" :action="selectedAgendamento?.id ? '/agenda/' + selectedAgendamento.id : '/agenda'">
                    @csrf
                    @if($errors->any())
                        <div class="p-6 bg-red-50 border-b border-red-100">
                            <div class="text-red-600 font-medium mb-2">Por favor, corrija os erros abaixo:</div>
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <template x-if="selectedAgendamento?.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div class="p-6 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Mutirão (Opcional)</label>
                            <select name="mutirao_id" x-model="selectedAgendamento.mutirao_id" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2">
                                <option value="">Sem vínculo com mutirão</option>
                                @foreach($mutiroes as $mutirao)
                                    <option value="{{ $mutirao->id }}">{{ $mutirao->nome }} - {{ \Carbon\Carbon::parse($mutirao->data)->format('d/m/Y') }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Data</label>
                                <input type="date" name="data_agendamento" x-model="selectedAgendamento.data_agendamento" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Horário</label>
                                <input type="time" name="horario" x-model="selectedAgendamento.horario" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Animal</label>
                            <select name="animal_id" x-model="selectedAgendamento.animal_id" @change="updatePrice()" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2" required>
                                <option value="">Selecione um animal...</option>
                                @foreach($animais as $animal)
                                    <option value="{{ $animal['id'] }}">{{ $animal['nome'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Tutor</label>
                            <select name="tutor_id" x-model="selectedAgendamento.tutor_id" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2">
                                <option value="">Selecione um tutor...</option>
                                @foreach($tutores as $tutor)
                                    <option value="{{ $tutor['id'] }}">{{ $tutor['nome'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Convênio</label>
                            <select name="convenio_id" x-model="selectedAgendamento.convenio_id" @change="updatePrice()" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2">
                                <option value="">Selecione um convênio...</option>
                                @foreach($convenios as $convenio)
                                    <option value="{{ $convenio['id'] }}">{{ $convenio['nome'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Valor</label>
                                <input type="number" step="0.01" name="valor" x-model="selectedAgendamento.valor" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Status</label>
                                <select name="status" x-model="selectedAgendamento.status" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2">
                                    <option value="Agendado">Agendado</option>
                                    <option value="Confirmado">Confirmado</option>
                                    <option value="Realizado">Realizado</option>
                                    <option value="Cancelado">Cancelado</option>
                                    <option value="Não Compareceu">Não Compareceu</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                        <button type="button" @click="formOpen = false" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-amber-600 text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Check-in Modal --}}
        <div x-show="checkInModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-transition>
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 overflow-hidden" @click.outside="checkInModalOpen = false">
                <div class="flex items-center justify-between p-6 border-b">
                    <h2 class="text-lg font-semibold">Realizar Check-in</h2>
                    <button @click="checkInModalOpen = false" class="text-slate-400 hover:text-slate-500">
                        <x-icon name="X" class="w-6 h-6" />
                    </button>
                </div>
                <form method="POST" :action="'/agenda/' + checkInId + '/checkin'">
                    @csrf
                    <div class="p-6 space-y-4">
                        <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                            <p class="text-sm text-indigo-800 font-medium">Animal: <span x-text="checkInAnimal"></span></p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none">Peso Atual (kg) *</label>
                            <input type="number" step="0.1" name="peso_medido" x-model="checkInWeight" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                        </div>

                        <div class="flex items-start gap-3 p-4 border rounded-lg bg-slate-50">
                            <input type="checkbox" name="jejum_ok" id="jejum_ok" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600" required>
                            <label for="jejum_ok" class="text-sm text-slate-600 cursor-pointer">
                                Confirmo que o animal cumpriu o jejum obrigatório de 8 horas (água e comida).
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                        <button type="button" @click="checkInModalOpen = false" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-md hover:bg-slate-50">Cancelar</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Confirmar Check-in</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-transition>
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 overflow-hidden" @click.outside="deleteModalOpen = false">
                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-2">Confirmar exclusão</h2>
                    <p class="text-slate-500">Tem certeza que deseja excluir este agendamento? Esta ação não pode ser desfeita.</p>
                </div>
                <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                    <button @click="deleteModalOpen = false" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-slate-100">
                        Cancelar
                    </button>
                    <form method="POST" :action="'/agenda/' + deleteId">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-red-600 text-white hover:bg-red-700">
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
