<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutores - Mutirão Amigo</title>
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
        selectedTutor: null,
        deleteId: null,
        
        openForm(tutor = null) {
            this.selectedTutor = tutor ? {...tutor} : {
                nome: '',
                tipo: 'Tutor',
                cpf: '',
                telefone: '',
                email: '',
                endereco: '',
                bairro: '',
                cidade: '',
                uf: '',
                cep: '',
                observacoes: ''
            };
            this.formOpen = true;
        },

        confirmDelete(id) {
            this.deleteId = id;
            this.deleteModalOpen = true;
        }
     }">
        <div class="header">
            <h1 class="title">Tutores</h1>
            <div class="flex gap-4">
                <button @click="openForm()" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-blue-600 text-white hover:bg-blue-700 shadow-sm">
                    <x-icon name="Users" class="w-4 h-4 mr-2" />
                    Novo Tutor
                </button>
                <a href="{{ route('internal.dashboard') }}" class="btn-back">Voltar para Painel</a>
            </div>
        </div>

        {{-- Search --}}
        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-6">
            <form action="{{ route('tutores.index') }}" method="GET" class="relative">
                <x-icon name="Search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}"
                    placeholder="Buscar por nome, CPF ou telefone..." 
                    class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 pl-10 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                >
            </form>
        </div>

        {{-- Content --}}
        @if(count($tutores) === 0)
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-12 text-center">
                <div class="flex flex-col items-center justify-center gap-4">
                    <div class="p-4 bg-slate-50 rounded-full">
                        <x-icon name="Users" class="w-8 h-8 text-slate-400" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Nenhum tutor encontrado</h3>
                        <p class="text-slate-500 mt-1">Cadastre o primeiro tutor para começar</p>
                    </div>
                    <button @click="openForm()" class="inline-flex items-center justify-center h-9 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-blue-600 text-white hover:bg-blue-700 shadow-sm mt-2">
                        Cadastrar Tutor
                    </button>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-slate-50/50 data-[state=selected]:bg-slate-50 bg-slate-50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Nome</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">CPF</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Contato</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Cidade</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Animais</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 w-12"></th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @foreach($tutores as $tutor)
                                <tr class="border-b transition-colors hover:bg-slate-50/50 data-[state=selected]:bg-slate-50">
                                    <td class="p-4 align-middle">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-600 font-semibold">
                                                    {{ strtoupper(substr($tutor['nome'], 0, 1)) }}
                                                </span>
                                            </div>
                                            <span class="font-medium">{{ $tutor['nome'] }}</span>
                                            <span class="text-xs px-2 py-0.5 rounded-full {{ $tutor['tipo'] === 'Lar Temporário' ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-700' }}">
                                                {{ $tutor['tipo'] }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle">{{ $tutor['cpf'] ?? '-' }}</td>
                                    <td class="p-4 align-middle">
                                        <div class="space-y-1">
                                            @if(!empty($tutor['telefone']))
                                                <div class="flex items-center gap-2 text-sm">
                                                    {{-- Phone icon --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                                    {{ $tutor['telefone'] }}
                                                </div>
                                            @endif
                                            @if(!empty($tutor['email']))
                                                <div class="flex items-center gap-2 text-sm text-slate-500">
                                                    {{-- Mail icon --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                                    {{ $tutor['email'] }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        @if(!empty($tutor['cidade']))
                                            <div class="flex items-center gap-1 text-sm">
                                                {{-- MapPin icon --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                                {{ $tutor['cidade'] }}{{ !empty($tutor['uf']) ? ' - ' . $tutor['uf'] : '' }}
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-blue-100 text-blue-700 hover:bg-blue-100/80">
                                            {{ $tutor['animais_count'] }} {{ $tutor['animais_count'] === 1 ? 'animal' : 'animais' }}
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-slate-100 h-8 w-8">
                                                <x-icon name="Scissors" class="w-4 h-4 rotate-90" />
                                            </button>
                                            <div x-show="open" x-transition class="absolute right-0 z-50 mt-2 w-32 rounded-md border border-slate-200 bg-white p-1 shadow-md">
                                                <button @click="openForm({{ json_encode($tutor) }}); open = false" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-slate-100 focus:bg-slate-100 data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                                                    Editar
                                                </button>
                                                <button @click="confirmDelete({{ $tutor['id'] }}); open = false" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 text-red-600 focus:bg-red-50 data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                                                    Excluir
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
            <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl mx-4 overflow-hidden max-h-[90vh] overflow-y-auto" @click.outside="formOpen = false">
                <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
                    <h2 class="text-lg font-semibold" x-text="selectedTutor?.id ? 'Editar Tutor' : 'Novo Tutor'"></h2>
                    <button @click="formOpen = false" class="text-slate-400 hover:text-slate-500">
                        <span class="sr-only">Fechar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form method="POST" :action="selectedTutor?.id ? '/tutores/' + selectedTutor.id : '/tutores'">
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
                    <template x-if="selectedTutor?.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nome Completo *</label>
                                <input type="text" name="nome" x-model="selectedTutor.nome" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" required>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Tipo *</label>
                                <select name="tipo" x-model="selectedTutor.tipo" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                    <option value="Tutor">Tutor</option>
                                    <option value="Lar Temporário">Lar Temporário</option>
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">CPF *</label>
                                <input type="text" name="cpf" x-model="selectedTutor.cpf" placeholder="000.000.000-00" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" required>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Telefone *</label>
                                <input type="text" name="telefone" x-model="selectedTutor.telefone" placeholder="(00) 00000-0000" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" required>
                            </div>
                            
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">E-mail</label>
                                <input type="email" name="email" x-model="selectedTutor.email" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                            </div>
                            
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Endereço *</label>
                                <input type="text" name="endereco" x-model="selectedTutor.endereco" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" required>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Bairro *</label>
                                <input type="text" name="bairro" x-model="selectedTutor.bairro" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" required>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">CEP *</label>
                                <input type="text" name="cep" x-model="selectedTutor.cep" placeholder="00000-000" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" required>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Cidade *</label>
                                <input type="text" name="cidade" x-model="selectedTutor.cidade" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" required>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">UF *</label>
                                <input type="text" name="uf" x-model="selectedTutor.uf" maxlength="2" placeholder="SP" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2" required>
                            </div>
                            
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Observações</label>
                                <textarea name="observacoes" x-model="selectedTutor.observacoes" rows="3" class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                        <button type="button" @click="formOpen = false" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-transition>
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 overflow-hidden" @click.outside="deleteModalOpen = false">
                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-2">Confirmar exclusão</h2>
                    <p class="text-slate-500">Tem certeza que deseja excluir este tutor? Esta ação não pode ser desfeita.</p>
                </div>
                <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                    <button @click="deleteModalOpen = false" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-slate-100">
                        Cancelar
                    </button>
                    <form method="POST" :action="'/tutores/' + deleteId">
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
