<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Interno - Mutirão Amigo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
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
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 150px;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-icon {
            width: 48px;
            height: 48px;
            margin-bottom: 1rem;
            fill: #3b82f6;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #374151;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Painel Interno</h1>
            <a href="{{ route('home') }}" class="btn-back">Voltar para Home</a>
        </div>

        <div class="grid">
            <a href="{{ route('animais.index') }}" class="card">
                <svg class="card-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/><circle cx="12" cy="12" r="3"/></svg>
                <span class="card-title">Animais</span>
            </a>
            
            <a href="{{ route('tutores.index') }}" class="card">
                <svg class="card-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <span class="card-title">Tutores</span>
            </a>

            <a href="{{ route('veterinarios.index') }}" class="card">
                <svg class="card-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 2h2v5h5v2h-5v5h-2v-5H7v-2h5V5z"/></svg>
                <span class="card-title">Veterinários</span>
            </a>

            <a href="{{ route('mutiroes.index') }}" class="card">
                <svg class="card-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>
                <span class="card-title">Mutirões</span>
            </a>

            <a href="{{ route('convenios.index') }}" class="card">
                <svg class="card-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
                <span class="card-title">Convênios</span>
            </a>

            <a href="{{ route('agenda.index') }}" class="card">
                <svg class="card-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
                <span class="card-title">Agenda</span>
            </a>

            <!-- Relatórios link placeholder - assuming route might not exist yet, using # if not found in route list, but user asked for it so I will try to link to a generic reports page or similar if exists, otherwise I will use a placeholder route or create one if needed. Based on route list I saw 'relatorios.mutirao' and 'relatorios.convenios.export'. I'll link to a main reports index if possible, or just create a placeholder link for now as I didn't see a general 'relatorios.index' -->
            <a href="#" class="card" onclick="alert('Funcionalidade de Relatórios Gerais em desenvolvimento'); return false;">
                <svg class="card-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-4 14h-2v-4h2v4zm0-6h-2v-4h2v4zm-4 6H9v-8h2v8zm0-10H9V5h2v2z"/></svg>
                <span class="card-title">Relatórios</span>
            </a>
        </div>
    </div>
</body>
</html>
