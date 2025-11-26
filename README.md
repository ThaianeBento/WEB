# Mutirao Amigo

Plataforma Laravel para gerenciar mutiroes veterinarios, agenda, cadastro de animais/tutores e vitrine de adocao.

## Tecnologias
- PHP 8.2+, Laravel 12, Eloquent ORM, Blade.
- Vite com laravel-vite-plugin, Tailwind CSS 4 (@tailwindcss/vite) e Alpine.js (CDN).
- Axios para chamadas HTTP e Composer/NPM para gestao de dependencias.
- Pest para testes; filas Laravel habilitadas (queue:listen) quando necessario.

## Arquitetura
- Rotas: `routes/web.php` concentra rotas web e recursos REST (`animais`, `tutores`, `convenios`, `agenda`, `doacoes`, `empresas`, `veterinarios`, `mutiroes`, relatorios e acesso interno).
- Controladores (`app/Http/Controllers`): aplicam validacao e regras de negocio.
  - `MutiraoController` cria/edita mutiroes, anexa veterinarios (pivot `mutirao_veterinario`) e lista agendamentos associados.
  - `AgendaController` administra agendamentos, check-in e vinculacao com animal, tutor, convenio e mutirao.
  - `AnimaisDoacaoController` lista animais disponiveis para adocao com filtros e paginacao.
  - `RelatorioController` gera relatorios de mutiroes e exporta convenios.
  - Demais controladores seguem CRUD padrao para animais, tutores, convenios (com precos), empresas, veterinarios e doacoes.
- Modelos (`app/Models`): entidades Eloquent e relacionamentos principais.
  - `Mutirao` many-to-many `Veterinario` (via `mutirao_veterinario`) e `hasMany` `Agendamento`.
  - `Agendamento` pertence a `Animal`, `Tutor`, `Convenio` e `Mutirao`.
  - `Animal` possui imagens (`AnimalImage`), agendamentos e uma `Doacao`; pertence a `Tutor`.
  - `Tutor`, `Convenio` (com `Preco`), `Empresa`, `Veterinario` e `Doacao` completam o dominio.
- Views: Blade em `resources/views` com layout base `layouts/app.blade.php`, componentes reutilizaveis (`resources/views/components`) e paginas publicas (`home`, `servicos`, `sobre-nos`) mais telas administrativas.
- Frontend: `resources/css/app.css` usa Tailwind 4 e tema custom; `resources/js/bootstrap.js` registra Axios; `vite.config.js` integra Vite e Tailwind.
- Banco: migrations em `database/migrations` versionam o schema para tutores, convenios + precos, animais + imagens, agendamentos, doacoes, empresas, veterinarios, mutiroes, pivot de veterinarios e campos de check-in.

## Como rodar localmente
1. Pre-requisitos: PHP 8.2+, Composer, Node 20+ e npm, banco configurado no `.env`.
2. Crie o `.env`: `cp .env.example .env` e ajuste variaveis `DB_*` (SQLite/MySQL/Postgres).
3. Instale dependencias: `composer install` e `npm install`.
4. Gere a chave e migre: `php artisan key:generate` e `php artisan migrate`.
5. Desenvolvimento: `php artisan serve` (opcional `php artisan queue:listen --tries=1`) e, em paralelo, `npm run dev`. Acesse em `http://localhost:8000`.
6. Build/producao: `npm run build` e sirva os assets gerados; combine com `php artisan config:cache` e `php artisan route:cache` conforme o ambiente.

Scripts uteis: `composer setup` (esteira de setup completa e build) e `composer test`/`php artisan test` (Pest).

## Estrutura rapida
- `app/Models/` entidades e relacionamentos.
- `app/Http/Controllers/` logica de aplicacao e validacoes.
- `routes/web.php` rotas nomeadas e recursos.
- `resources/views/` paginas Blade e componentes.
- `resources/css` e `resources/js` estilos Tailwind e bootstrap JS (Axios).
- `database/migrations/` versionamento do schema.
- `tests/` suite de testes Pest.

## Licenca
Baseado no Laravel (MIT). Ajuste conforme a licenca do Mutirao Amigo.
