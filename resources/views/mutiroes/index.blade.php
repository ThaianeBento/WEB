<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutirões - Mutirão Amigo</title>
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
        teamModalOpen: false,
        deleteModalOpen: false, 
        selectedMutirao: null,
        deleteId: null,
        
        openForm(mutirao = null) {
            this.selectedMutirao = mutirao ? {...mutirao} : {
                nome: '',
                data: '',
                local: '',
                capacidade: '',
                status: 'Planejado',
                observacoes: ''
            };
            this.formOpen = true;
        },

        openTeamModal(mutirao) {
            this.selectedMutirao = mutirao;
            this.teamModalOpen = true;
        },

        confirmDelete(id) {
            this.deleteId = id;
            this.deleteModalOpen = true;
        },

        formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('pt-BR');
        }
     }">
        <div class="header">
            <h1 class="title">Mutirões</h1>
            <div class="flex gap-4">
                <button @click="openForm()" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm">
                    <x-icon name="Plus" class="w-4 h-4 mr-2" />
                    Novo Mutirão
                </button>
                <a href="{{ route('internal.dashboard') }}" class="btn-back">Voltar para Painel</a>
            </div>
        </div>

        {{-- Search --}}
        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-6">
            <form action="{{ route('mutiroes.index') }}" method="GET" class="relative">
                <x-icon name="Search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}"
                    placeholder="Buscar por Nome ou Local..." 
                    class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 pl-10 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-600 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                >
            </form>
        </div>

        {{-- Content --}}
        @if($mutiroes->isEmpty())
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-12 text-center">
                <div class="flex flex-col items-center justify-center gap-4">
                    <div class="p-4 bg-slate-50 rounded-full">
                        <x-icon name="Calendar" class="w-8 h-8 text-slate-400" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Nenhum mutirão encontrado</h3>
                        <p class="text-slate-500 mt-1">Agende o primeiro mutirão para começar</p>
                    </div>
                    <button @click="openForm()" class="inline-flex items-center justify-center h-9 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm mt-2">
                        Agendar Mutirão
                    </button>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($mutiroes as $mutirao)
                    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-semibold text-lg text-slate-900">{{ $mutirao->nome }}</h3>
                                    <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                                        <x-icon name="Calendar" class="w-4 h-4" />
                                        {{ \Carbon\Carbon::parse($mutirao->data)->format('d/m/Y') }}
                                    </div>
                                </div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                    @if($mutirao->status === 'Planejado') bg-blue-100 text-blue-800
                                    @elseif($mutirao->status === 'Aberto') bg-green-100 text-green-800
                                    @elseif($mutirao->status === 'Concluído') bg-slate-100 text-slate-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $mutirao->status }}
                                </span>
                            </div>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center gap-2 text-sm text-slate-600">
                                    <x-icon name="MapPin" class="w-4 h-4 text-slate-400" />
                                    {{ $mutirao->local }}
                                </div>
                                <div class="flex items-center gap-2 text-sm text-slate-600">
                                    <x-icon name="Users" class="w-4 h-4 text-slate-400" />
                                    {{ $mutirao->veterinarios->count() }} membros na equipe
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button @click="openTeamModal({{ json_encode($mutirao->load('veterinarios')) }})" class="flex-1 inline-flex items-center justify-center h-9 px-3 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-slate-50 text-slate-700">
                                    Equipe
                                </button>
                                <button @click="openForm({{ json_encode($mutirao) }})" class="flex-1 inline-flex items-center justify-center h-9 px-3 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-slate-50 text-slate-700">
                                    Editar
                                </button>
                                <button @click="confirmDelete({{ $mutirao->id }})" class="inline-flex items-center justify-center h-9 w-9 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-red-50 text-red-600">
                                    <x-icon name="Trash2" class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Form Modal --}}
        <div x-show="formOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-transition>
            <div class="bg-white rounded-xl shadow-lg w-full max-w-lg mx-4 overflow-hidden" @click.outside="formOpen = false">
                <div class="flex items-center justify-between p-6 border-b">
                    <h2 class="text-lg font-semibold" x-text="selectedMutirao?.id ? 'Editar Mutirão' : 'Novo Mutirão'"></h2>
                    <button @click="formOpen = false" class="text-slate-400 hover:text-slate-500">
                        <x-icon name="X" class="w-6 h-6" />
                    </button>
                </div>
                <form method="POST" :action="selectedMutirao?.id ? '/mutiroes/' + selectedMutirao.id : '/mutiroes'">
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
                    <template x-if="selectedMutirao?.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div class="p-6 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none">Nome do Evento *</label>
                            <input type="text" name="nome" x-model="selectedMutirao.nome" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none">Data *</label>
                                <input type="date" name="data" x-model="selectedMutirao.data" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none">Capacidade *</label>
                                <input type="number" name="capacidade" x-model="selectedMutirao.capacidade" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none">Local *</label>
                            <input type="text" name="local" x-model="selectedMutirao.local" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none">Status *</label>
                            <select name="status" x-model="selectedMutirao.status" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                <option value="Planejado">Planejado</option>
                                <option value="Aberto">Aberto (Inscrições)</option>
                                <option value="Concluído">Concluído</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none">Observações</label>
                            <textarea name="observacoes" x-model="selectedMutirao.observacoes" class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600"></textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                        <button type="button" @click="formOpen = false" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-md hover:bg-slate-50">Cancelar</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Team Modal --}}
        <div x-show="teamModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-transition>
            <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl mx-4 overflow-hidden max-h-[90vh] overflow-y-auto" @click.outside="teamModalOpen = false">
                <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
                    <div>
                        <h2 class="text-lg font-semibold">Gerenciar Equipe</h2>
                        <p class="text-sm text-slate-500" x-text="selectedMutirao?.nome"></p>
                    </div>
                    <button @click="teamModalOpen = false" class="text-slate-400 hover:text-slate-500">
                        <x-icon name="X" class="w-6 h-6" />
                    </button>
                </div>
                
                <div class="p-6 space-y-6">
                    {{-- Add Member Form --}}
                    <form :action="'/mutiroes/' + selectedMutirao?.id + '/veterinarios'" method="POST" class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                        @csrf
                        <h3 class="text-sm font-medium mb-3">Adicionar Membro</h3>
                        <div class="flex gap-3">
                            <div class="flex-1">
                                <select name="veterinario_id" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                                    <option value="">Selecione o Veterinário</option>
                                    @foreach($veterinarios as $vet)
                                        <option value="{{ $vet->id }}">{{ $vet->nome }} ({{ $vet->crmv }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-1/3">
                                <select name="funcao" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                                    <option value="Cirurgião">Cirurgião</option>
                                    <option value="Anestesista">Anestesista</option>
                                    <option value="Auxiliar">Auxiliar</option>
                                    <option value="Voluntário">Voluntário</option>
                                </select>
                            </div>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                Adicionar
                            </button>
                        </div>
                    </form>

                    {{-- Team List --}}
                    <div>
                        <h3 class="text-sm font-medium mb-3">Membros Atuais</h3>
                        <div class="border rounded-lg overflow-hidden">
                            <table class="w-full text-sm">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-medium text-slate-500">Nome</th>
                                        <th class="px-4 py-3 text-left font-medium text-slate-500">Função</th>
                                        <th class="px-4 py-3 text-right font-medium text-slate-500">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <template x-if="selectedMutirao?.veterinarios && selectedMutirao.veterinarios.length > 0">
                                        <template x-for="vet in selectedMutirao.veterinarios" :key="vet.id">
                                            <tr>
                                                <td class="px-4 py-3" x-text="vet.nome"></td>
                                                <td class="px-4 py-3">
                                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-slate-100 text-slate-800" x-text="vet.pivot.funcao"></span>
                                                </td>
                                                <td class="px-4 py-3 text-right">
                                                    <form :action="'/mutiroes/' + selectedMutirao.id + '/veterinarios/' + vet.id" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-700 text-xs font-medium">Remover</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </template>
                                    </template>
                                    <template x-if="!selectedMutirao?.veterinarios || selectedMutirao.veterinarios.length === 0">
                                        <tr>
                                            <td colspan="3" class="px-4 py-8 text-center text-slate-500">
                                                Nenhum membro na equipe ainda.
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-transition>
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 overflow-hidden" @click.outside="deleteModalOpen = false">
                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-2">Confirmar exclusão</h2>
                    <p class="text-slate-500">Tem certeza que deseja excluir este mutirão? Esta ação não pode ser desfeita.</p>
                </div>
                <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                    <button @click="deleteModalOpen = false" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-md hover:bg-slate-50">Cancelar</button>
                    <form method="POST" :action="'/mutiroes/' + deleteId">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
