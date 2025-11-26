@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-indigo-50 p-6" 
     x-data="{ 
        formOpen: false, 
        deleteModalOpen: false, 
        selectedEmpresa: null,
        deleteId: null,
        
        openForm(empresa = null) {
            this.selectedEmpresa = empresa ? {...empresa} : {
                razao_social: '',
                cnpj: '',
                telefone: '',
                email: '',
                endereco: '',
                bairro: '',
                cidade: '',
                uf: '',
                cep: ''
            };
            this.formOpen = true;
        },

        confirmDelete(id) {
            this.deleteId = id;
            this.deleteModalOpen = true;
        }
     }">
    
    <div class="max-w-7xl mx-auto">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-white rounded-xl shadow-sm border border-slate-100">
                    <x-icon name="Building2" class="w-6 h-6 text-indigo-600" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Empresas</h1>
                    <p class="text-slate-500">Gerencie as empresas prestadoras de serviço</p>
                </div>
            </div>
            <button @click="openForm()" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm">
                <x-icon name="Building2" class="w-4 h-4 mr-2" />
                Nova Empresa
            </button>
        </div>

        {{-- Search --}}
        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-6">
            <form action="{{ route('empresas.index') }}" method="GET" class="relative">
                <x-icon name="Search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}"
                    placeholder="Buscar por Razão Social ou CNPJ..." 
                    class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 pl-10 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-600 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                >
            </form>
        </div>

        {{-- Content --}}
        @if($empresas->isEmpty())
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-12 text-center">
                <div class="flex flex-col items-center justify-center gap-4">
                    <div class="p-4 bg-slate-50 rounded-full">
                        <x-icon name="Building2" class="w-8 h-8 text-slate-400" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Nenhuma empresa encontrada</h3>
                        <p class="text-slate-500 mt-1">Cadastre a primeira empresa para começar</p>
                    </div>
                    <button @click="openForm()" class="inline-flex items-center justify-center h-9 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm mt-2">
                        Cadastrar Empresa
                    </button>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-slate-50/50 data-[state=selected]:bg-slate-50 bg-slate-50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Razão Social</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">CNPJ</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Contato</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500">Cidade</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 w-12"></th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @foreach($empresas as $empresa)
                                <tr class="border-b transition-colors hover:bg-slate-50/50 data-[state=selected]:bg-slate-50">
                                    <td class="p-4 align-middle">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                                <x-icon name="Building2" class="w-5 h-5 text-indigo-600" />
                                            </div>
                                            <span class="font-medium">{{ $empresa->razao_social }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle">{{ $empresa->cnpj }}</td>
                                    <td class="p-4 align-middle">
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2 text-sm">
                                                <x-icon name="Phone" class="w-3 h-3 text-slate-400" />
                                                {{ $empresa->telefone }}
                                            </div>
                                            @if($empresa->email)
                                                <div class="flex items-center gap-2 text-sm text-slate-500">
                                                    <x-icon name="Mail" class="w-3 h-3 text-slate-400" />
                                                    {{ $empresa->email }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="flex items-center gap-1 text-sm">
                                            <x-icon name="MapPin" class="w-3 h-3 text-slate-400" />
                                            {{ $empresa->cidade }} - {{ $empresa->uf }}
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-slate-100 h-8 w-8">
                                                <x-icon name="Scissors" class="w-4 h-4 rotate-90" />
                                            </button>
                                            <div x-show="open" x-transition class="absolute right-0 z-50 mt-2 w-32 rounded-md border border-slate-200 bg-white p-1 shadow-md">
                                                <button @click="openForm({{ json_encode($empresa) }}); open = false" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-slate-100 focus:bg-slate-100">
                                                    Editar
                                                </button>
                                                <button @click="confirmDelete({{ $empresa->id }}); open = false" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 text-red-600 focus:bg-red-50">
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
                <h2 class="text-lg font-semibold" x-text="selectedEmpresa?.id ? 'Editar Empresa' : 'Nova Empresa'"></h2>
                <button @click="formOpen = false" class="text-slate-400 hover:text-slate-500">
                    <span class="sr-only">Fechar</span>
                    <x-icon name="X" class="w-6 h-6" />
                </button>
            </div>
            <form method="POST" :action="selectedEmpresa?.id ? '/empresas/' + selectedEmpresa.id : '/empresas'">
                @csrf
                <template x-if="selectedEmpresa?.id">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Razão Social *</label>
                            <input type="text" name="razao_social" x-model="selectedEmpresa.razao_social" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" required>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">CNPJ *</label>
                            <input type="text" name="cnpj" x-model="selectedEmpresa.cnpj" placeholder="00.000.000/0000-00" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" required>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Telefone *</label>
                            <input type="text" name="telefone" x-model="selectedEmpresa.telefone" placeholder="(00) 0000-0000" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" required>
                        </div>
                        
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">E-mail</label>
                            <input type="email" name="email" x-model="selectedEmpresa.email" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                        </div>
                        
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Endereço *</label>
                            <input type="text" name="endereco" x-model="selectedEmpresa.endereco" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" required>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Bairro *</label>
                            <input type="text" name="bairro" x-model="selectedEmpresa.bairro" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" required>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">CEP *</label>
                            <input type="text" name="cep" x-model="selectedEmpresa.cep" placeholder="00000-000" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" required>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Cidade *</label>
                            <input type="text" name="cidade" x-model="selectedEmpresa.cidade" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" required>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">UF *</label>
                            <input type="text" name="uf" x-model="selectedEmpresa.uf" maxlength="2" placeholder="SP" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" required>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                    <button type="button" @click="formOpen = false" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        Cancelar
                    </button>
                    <button type="submit" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
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
                <p class="text-slate-500">Tem certeza que deseja excluir esta empresa? Esta ação não pode ser desfeita.</p>
            </div>
            <div class="flex items-center justify-end gap-2 p-6 border-t bg-slate-50">
                <button @click="deleteModalOpen = false" class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors border border-slate-200 bg-white hover:bg-slate-100">
                    Cancelar
                </button>
                <form method="POST" :action="'/empresas/' + deleteId">
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
