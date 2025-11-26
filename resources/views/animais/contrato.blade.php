<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Adoção - {{ $animal->nome }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-white text-slate-900 p-8 max-w-4xl mx-auto">
    
    {{-- Print Controls --}}
    <div class="no-print mb-8 flex justify-end gap-4">
        <button onclick="window.print()" class="bg-slate-900 text-white px-4 py-2 rounded-md hover:bg-slate-800 transition-colors">
            Imprimir Contrato
        </button>
    </div>

    {{-- Header --}}
    <div class="text-center mb-12 border-b pb-8">
        <h1 class="text-3xl font-bold mb-2">Termo de Adoção Responsável</h1>
        <p class="text-slate-500">Mutirão Amigo - Proteção Animal</p>
    </div>

    {{-- Content --}}
    <div class="space-y-8 text-justify leading-relaxed">
        <p>
            Pelo presente termo, eu, <strong>__________________________________________________________________</strong>,
            portador(a) do CPF nº <strong>__________________________</strong> e RG nº <strong>__________________________</strong>,
            residente à <strong>_______________________________________________________________________________________</strong>,
            na cidade de <strong>__________________________</strong>, telefone <strong>__________________________</strong>,
            assumo a responsabilidade pela adoção do animal descrito abaixo:
        </p>

        {{-- Animal Details --}}
        <div class="bg-slate-50 p-6 rounded-lg border border-slate-200">
            <h2 class="font-bold text-lg mb-4">Dados do Animal</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-slate-500 text-sm block">Nome</span>
                    <span class="font-medium">{{ $animal->nome }}</span>
                </div>
                <div>
                    <span class="text-slate-500 text-sm block">Espécie</span>
                    <span class="font-medium">{{ $animal->especie }}</span>
                </div>
                <div>
                    <span class="text-slate-500 text-sm block">Sexo</span>
                    <span class="font-medium">{{ $animal->sexo }}</span>
                </div>
                <div>
                    <span class="text-slate-500 text-sm block">Raça</span>
                    <span class="font-medium">{{ $animal->raca ?? 'SRD' }}</span>
                </div>
                <div>
                    <span class="text-slate-500 text-sm block">Cor/Pelagem</span>
                    <span class="font-medium">{{ $animal->cor ?? 'Não informada' }}</span>
                </div>
                <div>
                    <span class="text-slate-500 text-sm block">Microchip</span>
                    <span class="font-medium">{{ $animal->microchip ?? 'Não possui' }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="font-bold text-lg">Comprometo-me a:</h3>
            <ul class="list-disc pl-5 space-y-2">
                <li>Garantir o bem-estar do animal, oferecendo alimentação de qualidade, água fresca, abrigo seguro e limpo.</li>
                <li>Providenciar assistência veterinária sempre que necessário, incluindo vacinação anual e vermifugação periódica.</li>
                <li>Não manter o animal acorrentado ou em espaços exíguos que limitem sua movimentação e conforto.</li>
                <li>Jamais abandonar o animal. Em caso de impossibilidade de mantê-lo, comprometo-me a devolvê-lo ao Mutirão Amigo ou encontrar um novo lar responsável, com o conhecimento da ONG.</li>
                <li>Permitir visitas de acompanhamento por parte dos voluntários do Mutirão Amigo, se solicitado.</li>
                <li>Estar ciente de que maus-tratos a animais é crime previsto em lei (Lei 9.605/98).</li>
            </ul>
        </div>

        <p class="mt-8">
            Declaro estar ciente de todas as responsabilidades que a adoção implica e assino este termo de livre e espontânea vontade.
        </p>

        {{-- Signatures --}}
        <div class="grid grid-cols-2 gap-12 mt-24 pt-12">
            <div class="text-center border-t border-slate-400 pt-4">
                <p class="font-medium">Adotante</p>
            </div>
            <div class="text-center border-t border-slate-400 pt-4">
                <p class="font-medium">Mutirão Amigo</p>
            </div>
        </div>

        <div class="text-center text-slate-500 text-sm mt-12">
            <p>{{ date('d/m/Y') }}</p>
        </div>
    </div>
</body>
</html>
