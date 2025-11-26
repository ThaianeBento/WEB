@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-rose-50 p-6" 
     x-data="{ 
        formOpen: false, 
        deleteModalOpen: false, 
        selectedDoacao: null,
        deleteId: null,
        
        openForm(doacao = null) {
            this.selectedDoacao = doacao ? {...doacao} : {
                animal_id: '',
                data_doacao: new Date().toISOString().split('T')[0],
                adotante_nome: '',
                adotante_contato: '',
                observacoes: ''
            };
            this.formOpen = true;
        },

        confirmDelete(id) {
            this.deleteId = id;
            this.deleteModalOpen = true;
        },

        formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('pt-BR');
        }
     }">
    
    <div class="max-w-7xl mx-auto">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-white rounded-xl shadow-sm border border-slate-100">
                    <x-icon name="Heart" class="w-6 h-6 text-rose-600" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Doações Realizadas</h1>
                    <p class="text-slate-500">Histórico de animais adotados</p>
                </div>
            </div>
            <button @click="openForm()" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-rose-600 text-white hover:bg-rose-700 shadow-sm">
                <x-icon name="Heart" class="w-4 h-4 mr-2" />
                Registrar Adoção
            </button>
        </div>

        {{-- Filters --}}
        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-6">
            <form action="{{ route('doacoes.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <x-icon name="Search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $filters['search'] }}"
                        placeholder="Buscar por animal ou adotante..." 
                        class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 pl-10 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-600 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                </div>
            </form>
        </div>

        {{-- Content --}}
        @if($doacoes->isEmpty())
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-12 text-center">
                <div class="flex flex-col items-center justify-center gap-4">
                    <div class="p-4 bg-rose-50 rounded-full">
                        <x-icon name="Heart" class="w-8 h-8 text-rose-400" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Nenhuma doação registrada</h3>
                        <p class="text-slate-500 mt-1">Registre a primeira adoção para começar o histórico</p>
                    </div>
                    <button @click="openForm()" class="inline-flex items-center justify-center h-9 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-rose-600 text-white hover:bg-rose-700 shadow-sm mt-2">
                        Registrar Adoção
                    </button>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-slate-50/50 data-[state=selected]:bg-slate-50 bg-slate-50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Animal</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Data Adoção</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Adotante</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Contato</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 w-12"></th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @foreach($doacoes as $doacao)
                                <tr class="border-b transition-colors hover:bg-slate-50/50 data-[state=selected]:bg-slate-50">
                                    <td class="p-4 align-middle">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-rose-100 flex items-center justify-center">
                                                <x-icon name="Heart" class="w-5 h-5 text-rose-600" />
                                            </div>
                                            <span class="font-medium">{{ $doacao->animal->nome ?? 'Animal Removido' }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        {{ \Carbon\Carbon::parse($doacao->data_doacao)->format('d/m/Y') }}
                                    </td>
                                    <td class="p-4 align-middle">{{ $doacao->adotante_nome }}</td>
                                    <td class="p-4 align-middle">{{ $doacao->adotante_contato }}</td>
                                    <td class="p-4 align-middle">
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-slate-100 h-8 w-8">
                                                <x-icon name="Scissors" class="w-4 h-4 rotate-90" />
                                            </button>
                                            <div x-show="open" x-transition class="absolute right-0 z-50 mt-2 w-32 rounded-md border border-slate-200 bg-white p-1 shadow-md">
                                                <button @click="openForm({{ json_encode($doacao) }}); open = false" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-slate-100 focus:bg-slate-100">
                                                    Editar
                                                </button>
                                                <button @click="confirmDelete({{ $doacao->id }}); open = false" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 text-red-600 focus:bg-red-50">
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
    </div>

    {{-- Form Modal --}}
    <div x-show="formOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-transition>
        <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl mx-4 overflow-hidden max-h-[90vh] overflow-y-auto" @click.outside="formOpen = false">
            <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
                <h2 class="text-lg font-semibold" x-text="selectedDoacao?.id ? 'Editar Adoção' : 'Registrar Adoção'"></h2>
                <button @click="formOpen = false" class="text-slate-400 hover:text-slate-500">
                    <span class="sr-only">Fechar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form method="POST" :action="selectedDoacao?.id ? '/doacoes/' + selectedDoacao.id : '/doacoes'">
                @csrf
                <template x-if="selectedDoacao?.id">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Animal *</label>
                            <select name="animal_id" x-model="selectedDoacao.animal_id" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-600 focus:ring-offset-2" required>
                                <option value="">Selecione o animal</option>
                                @foreach($animais as $animal)
                                    <option value="{{ $animal->id }}">{{ $animal->nome }} ({{ $animal->especie }})</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-500">Apenas animais disponíveis para doação são listados.</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Data Adoção *</label>
                            <input type="date" name="data_doacao" x-model="selectedDoacao.data_doacao" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-rose-600 focus:ring-offset-2" required>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nome do Adotante *</label>
                            <input type="text" name="adotante_nome" x-model="selectedDoacao.adotante_nome" placeholder="Nome completo" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-rose-600 focus:ring-offset-2" required>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Contato do Adotante *</label>
                            <input type="text" name="adotante_contato" x-model="selectedDoacao.adotante_contato" placeholder="Telefone ou Email" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-rose-600 focus:ring-offset-2" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Observações</label>
                        <textarea name="observacoes" x-model="selectedDoacao.observacoes" rows="3" placeholder="Detalhes adicionais sobre a adoção..." class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-rose-600 focus:ring-offset-2"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                    <button type="button" @click="formOpen = false" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        Cancelar
                    </button>
                    <button type="submit" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-rose-600 text-white hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-600 focus:ring-offset-2">
                        Registrar
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
                <p class="text-slate-500">Tem certeza que deseja excluir este registro de adoção? Esta ação não pode ser desfeita.</p>
            </div>
            <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                <button @click="deleteModalOpen = false" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-slate-100">
                    Cancelar
                </button>
                <form method="POST" :action="'/doacoes/' + deleteId">
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
@endsection
