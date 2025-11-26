<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animais - Mutirão Amigo</title>
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
        selectedAnimal: null,
        deleteId: null,
        uploading: false,
        
        openForm(animal = null) {
            this.selectedAnimal = animal ? {...animal} : {
                nome: '',
                especie: '',
                raca: '',
                srd: false,
                sexo: '',
                idade: '',
                data_nascimento_estimada: false,
                peso: '',
                porte: '',
                cor: '',
                foto_url: '',
                tutor_id: '',
                status: 'Cadastrado',
                status_reprodutivo: 'Desconhecido',
                castrado: false,
                disponivel_doacao: false,
                microchip: '',
                observacoes: '',
                images: []
            };
            this.formOpen = true;
        },

        confirmDelete(id) {
            this.deleteId = id;
            this.deleteModalOpen = true;
        },

        handleFileUpload(event) {
            const files = event.target.files;
            if (!files.length) return;
            
            this.uploading = true;
            
            // Simulate upload delay for better UX
            setTimeout(() => {
                Array.from(files).forEach(file => {
                    const url = URL.createObjectURL(file);
                    if (!this.selectedAnimal.images) this.selectedAnimal.images = [];
                    this.selectedAnimal.images.push({
                        id: 'temp_' + Date.now() + Math.random(),
                        path: url,
                        is_primary: this.selectedAnimal.images.length === 0
                    });
                });
                this.uploading = false;
            }, 500);
        }
     }">
        <div class="header">
            <h1 class="title">Animais</h1>
            <div class="flex gap-4">
                <button @click="openForm()" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-emerald-600 text-white hover:bg-emerald-700 shadow-sm">
                    <x-icon name="PawPrint" class="w-4 h-4 mr-2" />
                    Novo Animal
                </button>
                <a href="{{ route('internal.dashboard') }}" class="btn-back">Voltar para Painel</a>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-6">
            <form action="{{ route('animais.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <x-icon name="Search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $filters['search'] }}"
                        placeholder="Buscar por nome ou raça..." 
                        class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 pl-10 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                </div>
                <div class="flex gap-2">
                    <select name="especie" onchange="this.form.submit()" class="flex h-10 w-40 items-center justify-between rounded-md border border-slate-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="all" {{ $filters['especie'] === 'all' ? 'selected' : '' }}>Todas Espécies</option>
                        <option value="Cachorro" {{ $filters['especie'] === 'Cachorro' ? 'selected' : '' }}>Cachorro</option>
                        <option value="Gato" {{ $filters['especie'] === 'Gato' ? 'selected' : '' }}>Gato</option>
                        <option value="Outro" {{ $filters['especie'] === 'Outro' ? 'selected' : '' }}>Outro</option>
                    </select>

                    <select name="status" onchange="this.form.submit()" class="flex h-10 w-48 items-center justify-between rounded-md border border-slate-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="all" {{ $filters['status'] === 'all' ? 'selected' : '' }}>Todos Status</option>
                        <option value="Cadastrado" {{ $filters['status'] === 'Cadastrado' ? 'selected' : '' }}>Cadastrado</option>
                        <option value="Aguardando Castração" {{ $filters['status'] === 'Aguardando Castração' ? 'selected' : '' }}>Aguardando Castração</option>
                        <option value="Castrado" {{ $filters['status'] === 'Castrado' ? 'selected' : '' }}>Castrado</option>
                        <option value="Disponível para Doação" {{ $filters['status'] === 'Disponível para Doação' ? 'selected' : '' }}>Disponível para Doação</option>
                        <option value="Adotado" {{ $filters['status'] === 'Adotado' ? 'selected' : '' }}>Adotado</option>
                    </select>
                </div>
            </form>
        </div>

        {{-- Content --}}
        @if(count($animais) === 0)
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-12 text-center">
                <div class="flex flex-col items-center justify-center gap-4">
                    <div class="p-4 bg-slate-50 rounded-full">
                        <x-icon name="PawPrint" class="w-8 h-8 text-slate-400" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Nenhum animal encontrado</h3>
                        <p class="text-slate-500 mt-1">Cadastre o primeiro animal para começar</p>
                    </div>
                    <button @click="openForm()" class="inline-flex items-center justify-center h-9 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-emerald-600 text-white hover:bg-emerald-700 shadow-sm mt-2">
                        Cadastrar Animal
                    </button>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-slate-50/50 data-[state=selected]:bg-slate-50 bg-slate-50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 w-16"></th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Nome</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Espécie</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Raça</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Sexo</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Tutor</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Status</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 w-12"></th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @foreach($animais as $animal)
                                <tr class="border-b transition-colors hover:bg-slate-50/50 data-[state=selected]:bg-slate-50">
                                    <td class="p-4 align-middle">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden bg-slate-100 flex items-center justify-center">
                                            @if(!empty($animal['foto_url']))
                                                <img src="{{ $animal['foto_url'] }}" alt="{{ $animal['nome'] }}" class="w-full h-full object-cover" />
                                            @elseif($animal['especie'] === 'Cachorro')
                                                <x-icon name="Dog" class="w-5 h-5 text-slate-400" />
                                            @else
                                                <x-icon name="Cat" class="w-5 h-5 text-slate-400" />
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle font-medium">{{ $animal['nome'] }}</td>
                                    <td class="p-4 align-middle">{{ $animal['especie'] }}</td>
                                    <td class="p-4 align-middle">{{ $animal['raca'] ?? '-' }}</td>
                                    <td class="p-4 align-middle">{{ $animal['sexo'] }}</td>
                                    <td class="p-4 align-middle">{{ $animal['tutor_nome'] }}</td>
                                    <td class="p-4 align-middle">
                                        @php
                                            $statusColors = [
                                                "Cadastrado" => "bg-slate-100 text-slate-700",
                                                "Aguardando Castração" => "bg-amber-100 text-amber-700",
                                                "Castrado" => "bg-emerald-100 text-emerald-700",
                                                "Disponível para Doação" => "bg-rose-100 text-rose-700",
                                                "Adotado" => "bg-blue-100 text-blue-700"
                                            ];
                                            $colorClass = $statusColors[$animal['status']] ?? "bg-slate-100 text-slate-700";
                                        @endphp
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent {{ $colorClass }}">
                                            {{ $animal['status'] }}
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-slate-100 h-8 w-8">
                                                <x-icon name="Scissors" class="w-4 h-4 rotate-90" />
                                            </button>
                                            <div x-show="open" x-transition class="absolute right-0 z-50 mt-2 w-32 rounded-md border border-slate-200 bg-white p-1 shadow-md">
                                                <button @click="openForm({{ json_encode($animal) }}); open = false" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-slate-100 focus:bg-slate-100">
                                                    Editar
                                                </button>
                                                <button @click="confirmDelete({{ $animal['id'] }}); open = false" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 text-red-600 focus:bg-red-50">
                                                    Excluir
                                                </button>
                                                @if($animal['disponivel_doacao'])
                                                    <a href="{{ route('animais.contrato', $animal['id']) }}" target="_blank" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-slate-100 focus:bg-slate-100 text-slate-700">
                                                        Imprimir Contrato
                                                    </a>
                                                @endif
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
                    <h2 class="text-lg font-semibold" x-text="selectedAnimal?.id ? 'Editar Animal' : 'Novo Animal'"></h2>
                    <button @click="formOpen = false" class="text-slate-400 hover:text-slate-500">
                        <span class="sr-only">Fechar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form method="POST" :action="selectedAnimal?.id ? '/animais/' + selectedAnimal.id : '/animais'" enctype="multipart/form-data">
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
                    <template x-if="selectedAnimal?.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <input type="text" name="nome" x-model="selectedAnimal.nome" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2" required placeholder="Nome do animal">
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Microchip</label>
                                <input type="text" name="microchip" x-model="selectedAnimal.microchip" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Espécie *</label>
                                <select name="especie" x-model="selectedAnimal.especie" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                                    <option value="">Selecione</option>
                                    <option value="Cachorro">Cachorro</option>
                                    <option value="Gato">Gato</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Sexo *</label>
                                <select name="sexo" x-model="selectedAnimal.sexo" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                                    <option value="">Selecione</option>
                                    <option value="Macho">Macho</option>
                                    <option value="Fêmea">Fêmea</option>
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Raça</label>
                                <div class="flex gap-2">
                                    <input type="text" name="raca" x-model="selectedAnimal.raca" :disabled="selectedAnimal.srd" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 disabled:opacity-50">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" id="srd" name="srd" x-model="selectedAnimal.srd" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-600">
                                        <label for="srd" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">SRD</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Idade / Nascimento</label>
                                <div class="flex flex-col gap-2">
                                    <input type="text" name="idade" x-model="selectedAnimal.idade" placeholder="Ex: 2 anos" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" id="data_nascimento_estimada" name="data_nascimento_estimada" x-model="selectedAnimal.data_nascimento_estimada" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-600">
                                        <label for="data_nascimento_estimada" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Data Estimada</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Peso (kg)</label>
                                <input type="number" step="0.1" name="peso" x-model="selectedAnimal.peso" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Porte</label>
                                <select name="porte" x-model="selectedAnimal.porte" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                                    <option value="">Selecione</option>
                                    <option value="Pequeno">Pequeno</option>
                                    <option value="Médio">Médio</option>
                                    <option value="Grande">Grande</option>
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Cor/Pelagem</label>
                                <input type="text" name="cor" x-model="selectedAnimal.cor" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Tutor</label>
                                <select name="tutor_id" x-model="selectedAnimal.tutor_id" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                                    <option value="">Selecione o tutor</option>
                                    @foreach($tutores as $tutor)
                                        <option value="{{ $tutor['id'] }}">{{ $tutor['nome'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Status</label>
                                <select name="status" x-model="selectedAnimal.status" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                                    <option value="Cadastrado">Cadastrado</option>
                                    <option value="Aguardando Castração">Aguardando Castração</option>
                                    <option value="Castrado">Castrado</option>
                                    <option value="Disponível para Doação">Disponível para Doação</option>
                                    <option value="Adotado">Adotado</option>
                                </select>
                            </div>
                            
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Fotos do Animal</label>
                                
                                {{-- Existing Images --}}
                                <div class="flex flex-wrap gap-4 mb-4" x-show="selectedAnimal.images && selectedAnimal.images.length > 0">
                                    <template x-for="image in selectedAnimal.images" :key="image.id">
                                        <div class="relative w-24 h-24 rounded-lg overflow-hidden border border-slate-200 group">
                                            <img :src="image.path" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <span class="text-white text-xs" x-text="image.is_primary ? 'Principal' : ''"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div class="flex items-center gap-4">
                                    <label class="flex items-center gap-2 px-4 py-2 border rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                                        <template x-if="uploading">
                                            <x-icon name="Loader2" class="w-4 h-4 animate-spin" />
                                        </template>
                                        <template x-if="!uploading">
                                            <x-icon name="Upload" class="w-4 h-4" />
                                        </template>
                                        <span class="text-sm" x-text="uploading ? 'Enviando...' : 'Adicionar fotos'"></span>
                                        <input
                                            type="file"
                                            name="photos[]"
                                            multiple
                                            accept="image/*"
                                            @change="handleFileUpload"
                                            class="hidden"
                                        />
                                    </label>
                                    <span class="text-xs text-slate-500">Você pode selecionar várias fotos.</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-8">
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Status Reprodutivo</label>
                                <select name="status_reprodutivo" x-model="selectedAnimal.status_reprodutivo" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                                    <option value="Desconhecido">Desconhecido</option>
                                    <option value="Inteiro">Inteiro</option>
                                    <option value="Castrado">Castrado</option>
                                </select>
                            </div>
                            <div class="flex items-center gap-2">
                                <button 
                                    type="button" 
                                    role="switch" 
                                    :aria-checked="selectedAnimal.disponivel_doacao" 
                                    @click="selectedAnimal.disponivel_doacao = !selectedAnimal.disponivel_doacao" 
                                    :class="selectedAnimal.disponivel_doacao ? 'bg-emerald-600' : 'bg-slate-200'"
                                    class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 focus-visible:ring-offset-white"
                                >
                                    <span 
                                        :class="selectedAnimal.disponivel_doacao ? 'translate-x-5' : 'translate-x-0'"
                                        class="pointer-events-none block h-5 w-5 rounded-full bg-white shadow-lg ring-0 transition-transform"
                                    ></span>
                                </button>
                                <input type="hidden" name="disponivel_doacao" :value="selectedAnimal.disponivel_doacao ? 1 : 0">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Disponível para doação</label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Observações</label>
                            <textarea name="observacoes" x-model="selectedAnimal.observacoes" rows="3" class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2"></textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                        <button type="button" @click="formOpen = false" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-emerald-600 text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                            <template x-if="uploading">
                                <x-icon name="Loader2" class="w-4 h-4 mr-2 animate-spin" />
                            </template>
                            <span x-text="selectedAnimal?.id ? 'Salvar Alterações' : 'Cadastrar Animal'"></span>
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
                    <p class="text-slate-500">Tem certeza que deseja excluir este animal? Esta ação não pode ser desfeita.</p>
                </div>
                <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                    <button @click="deleteModalOpen = false" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-slate-100">
                        Cancelar
                    </button>
                    <form method="POST" :action="'/animais/' + deleteId">
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
