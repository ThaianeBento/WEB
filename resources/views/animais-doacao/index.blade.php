@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-rose-50 via-white to-pink-50"
     x-data="{ 
        selectedAnimal: null,
        openModal(animal) {
            this.selectedAnimal = animal;
        }
     }">
    
    {{-- Hero --}}
    <div class="relative bg-gradient-to-r from-rose-500 to-pink-500 text-white px-6 py-16">
        <div class="max-w-6xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm mb-6">
                <x-icon name="Heart" class="w-5 h-5" />
                <span class="font-medium">Adote um Amigo</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Encontre seu novo
                <br />
                melhor amigo
            </h1>
            <p class="text-lg text-rose-100 max-w-2xl mx-auto">
                Todos os animais disponíveis para adoção são castrados e prontos para encontrar um lar cheio de amor
            </p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 py-8">
        {{-- Filters --}}
        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-lg mb-8 -mt-8 relative z-10">
            <form action="{{ route('adotar.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <x-icon name="Search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $filters['search'] }}"
                        placeholder="Buscar por nome ou raça..." 
                        class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 pl-10 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-600 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                </div>
                <div class="flex gap-2">
                    <select name="especie" onchange="this.form.submit()" class="flex h-10 w-40 items-center justify-between rounded-md border border-slate-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-rose-600 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="all" {{ $filters['especie'] === 'all' ? 'selected' : '' }}>Todas Espécies</option>
                        <option value="Cachorro" {{ $filters['especie'] === 'Cachorro' ? 'selected' : '' }}>Cachorro</option>
                        <option value="Gato" {{ $filters['especie'] === 'Gato' ? 'selected' : '' }}>Gato</option>
                    </select>
                    <select name="sexo" onchange="this.form.submit()" class="flex h-10 w-40 items-center justify-between rounded-md border border-slate-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-rose-600 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="all" {{ $filters['sexo'] === 'all' ? 'selected' : '' }}>Todos Sexos</option>
                        <option value="Macho" {{ $filters['sexo'] === 'Macho' ? 'selected' : '' }}>Macho</option>
                        <option value="Fêmea" {{ $filters['sexo'] === 'Fêmea' ? 'selected' : '' }}>Fêmea</option>
                    </select>
                    <select name="porte" onchange="this.form.submit()" class="flex h-10 w-40 items-center justify-between rounded-md border border-slate-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-rose-600 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="all" {{ $filters['porte'] === 'all' ? 'selected' : '' }}>Todos Portes</option>
                        <option value="Pequeno" {{ $filters['porte'] === 'Pequeno' ? 'selected' : '' }}>Pequeno</option>
                        <option value="Médio" {{ $filters['porte'] === 'Médio' ? 'selected' : '' }}>Médio</option>
                        <option value="Grande" {{ $filters['porte'] === 'Grande' ? 'selected' : '' }}>Grande</option>
                    </select>
                </div>
            </form>
        </div>

        {{-- Results Count --}}
        <div class="mb-6">
            <p class="text-slate-600">
                {{ $animais->total() }} {{ $animais->total() === 1 ? 'animal encontrado' : 'animais encontrados' }}
            </p>
        </div>

        {{-- Content --}}
        @if(count($animais) === 0)
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-12 text-center">
                <div class="flex flex-col items-center justify-center gap-4">
                    <div class="p-4 bg-rose-50 rounded-full">
                        <x-icon name="Heart" class="w-8 h-8 text-rose-400" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Nenhum animal disponível</h3>
                        <p class="text-slate-500 mt-1">No momento não há animais disponíveis para adoção com os filtros selecionados</p>
                    </div>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($animais as $animal)
                    <div class="group relative overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all hover:shadow-xl cursor-pointer"
                         @click="openModal({{ json_encode($animal) }})">
                        <div class="aspect-square relative overflow-hidden bg-slate-100">
                            @if($animal['foto_url'])
                                <img 
                                    src="{{ $animal['foto_url'] }}" 
                                    alt="{{ $animal['nome'] }}"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                />
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-rose-100 to-pink-100">
                                    @if($animal['especie'] === 'Cachorro')
                                        <x-icon name="Dog" class="w-20 h-20 text-rose-300" />
                                    @else
                                        <x-icon name="Cat" class="w-20 h-20 text-rose-300" />
                                    @endif
                                </div>
                            @endif
                            
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center rounded-full bg-white/90 px-2.5 py-0.5 text-xs font-semibold text-rose-600 backdrop-blur-sm">
                                    @if($animal['especie'] === 'Cachorro')
                                        <x-icon name="Dog" class="w-3 h-3 mr-1" />
                                    @else
                                        <x-icon name="Cat" class="w-3 h-3 mr-1" />
                                    @endif
                                    {{ $animal['especie'] }}
                                </span>
                            </div>
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center rounded-full bg-rose-500 px-2.5 py-0.5 text-xs font-semibold text-white shadow-sm">
                                    <x-icon name="Heart" class="w-3 h-3 mr-1" />
                                    Adote
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-xl mb-2">{{ $animal['nome'] }}</h3>
                            <div class="flex flex-wrap gap-2 text-sm text-slate-500">
                                <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                    {{ $animal['sexo'] }}
                                </span>
                                @if(!empty($animal['idade']))
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                        {{ $animal['idade'] }}
                                    </span>
                                @endif
                                @if(!empty($animal['raca']))
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                        {{ $animal['raca'] }}
                                    </span>
                                @endif
                            </div>
                            @if($animal['castrado'])
                                <div class="mt-3 flex items-center gap-1 text-emerald-600 text-sm font-medium">
                                    <x-icon name="PawPrint" class="w-4 h-4" />
                                    Castrado
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $animais->appends($filters)->links() }}
            </div>
        @endif
    </div>

    {{-- Animal Details Modal --}}
    <div x-show="selectedAnimal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" x-transition>
        <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto" @click.outside="selectedAnimal = null">
            <template x-if="selectedAnimal">
                <div>
                    <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
                        <h2 class="text-2xl font-bold flex items-center gap-2 text-slate-800">
                            <x-icon name="Heart" class="w-6 h-6 text-rose-500" />
                            <span x-text="selectedAnimal.nome"></span>
                        </h2>
                        <button @click="selectedAnimal = null" class="text-slate-400 hover:text-slate-500 transition-colors">
                            <span class="sr-only">Fechar</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-6">
                        <template x-if="selectedAnimal.foto_url">
                            <div class="aspect-video rounded-xl overflow-hidden mb-6 bg-slate-100">
                                <img 
                                    :src="selectedAnimal.foto_url" 
                                    :alt="selectedAnimal.nome"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </template>
                        
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="p-4 bg-slate-50 rounded-xl">
                                <p class="text-sm text-slate-500 mb-1">Espécie</p>
                                <p class="font-semibold text-slate-900" x-text="selectedAnimal.especie"></p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-xl">
                                <p class="text-sm text-slate-500 mb-1">Sexo</p>
                                <p class="font-semibold text-slate-900" x-text="selectedAnimal.sexo"></p>
                            </div>
                            <template x-if="selectedAnimal.idade">
                                <div class="p-4 bg-slate-50 rounded-xl">
                                    <p class="text-sm text-slate-500 mb-1">Idade</p>
                                    <p class="font-semibold text-slate-900" x-text="selectedAnimal.idade"></p>
                                </div>
                            </template>
                            <template x-if="selectedAnimal.raca">
                                <div class="p-4 bg-slate-50 rounded-xl">
                                    <p class="text-sm text-slate-500 mb-1">Raça</p>
                                    <p class="font-semibold text-slate-900" x-text="selectedAnimal.raca"></p>
                                </div>
                            </template>
                            <template x-if="selectedAnimal.cor">
                                <div class="p-4 bg-slate-50 rounded-xl">
                                    <p class="text-sm text-slate-500 mb-1">Cor/Pelagem</p>
                                    <p class="font-semibold text-slate-900" x-text="selectedAnimal.cor"></p>
                                </div>
                            </template>
                            <template x-if="selectedAnimal.peso">
                                <div class="p-4 bg-slate-50 rounded-xl">
                                    <p class="text-sm text-slate-500 mb-1">Peso</p>
                                    <p class="font-semibold text-slate-900" x-text="selectedAnimal.peso + ' kg'"></p>
                                </div>
                            </template>
                        </div>
                        
                        <template x-if="selectedAnimal.castrado">
                            <div class="flex items-center gap-2 p-4 bg-emerald-50 rounded-xl mb-6 border border-emerald-100">
                                <x-icon name="PawPrint" class="w-5 h-5 text-emerald-600" />
                                <span class="text-emerald-700 font-medium">Este animal já foi castrado</span>
                            </div>
                        </template>
                        
                        <template x-if="selectedAnimal.observacoes">
                            <div class="p-4 bg-blue-50 rounded-xl mb-6 border border-blue-100">
                                <div class="flex items-center gap-2 mb-2">
                                    <x-icon name="Info" class="w-5 h-5 text-blue-600" />
                                    <span class="font-medium text-blue-700" x-text="'Sobre ' + selectedAnimal.nome"></span>
                                </div>
                                <p class="text-slate-600" x-text="selectedAnimal.observacoes"></p>
                            </div>
                        </template>
                        
                        <div class="p-4 bg-rose-50 rounded-xl border border-rose-100">
                            <p class="text-rose-700 font-medium mb-2">Interessado em adotar?</p>
                            <p class="text-slate-600 text-sm">
                                Entre em contato com a entidade responsável pelo Mutirão Amigo para mais informações sobre o processo de adoção.
                            </p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="px-6 py-8 border-t bg-white mt-8">
        <div class="max-w-6xl mx-auto text-center">
            <div class="flex items-center justify-center gap-2 mb-4">
                <x-icon name="PawPrint" class="w-6 h-6 text-rose-500" />
                <span class="font-bold text-slate-800">Mutirão Amigo</span>
            </div>
            <p class="text-sm text-slate-500">
                Adotar é um ato de amor. Encontre seu novo melhor amigo!
            </p>
        </div>
    </footer>
</div>
@endsection
