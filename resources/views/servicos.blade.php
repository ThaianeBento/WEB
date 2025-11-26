<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mutirão Amigo - Serviços</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background: #f9fafb;
            color: #4a5568;
        }
        header, footer {
            padding: 16px 40px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
        }
        nav {
            display: flex;
            align-items: center;
        }
        nav a {
            margin-left: 24px;
            text-decoration: none;
            color: #2d3748;
            font-weight: 500;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .btn-voltar {
            background-color: #e2e8f0;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background-color 0.2s;
        }
        .btn-voltar:hover {
            background-color: #cbd5e0;
            text-decoration: none;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 18px;
            color: #38b2ac;
            text-decoration: none;
        }
        .logo svg {
            width: 32px;
            height: 32px;
            fill: #38b2ac;
        }
        main {
            max-width: 960px;
            margin: 48px auto;
            padding: 0 20px 80px;
            text-align: center;
        }
        h1 {
            font-size: 2.4rem;
            margin-bottom: 8px;
            font-weight: 900;
            line-height: 1.2;
        }
        h1 .highlight-green {
            color: #38b2ac;
        }
        h1 .highlight-blue {
            color: #4299e1;
        }
        p.subtitle {
            font-size: 1rem;
            color: #718096;
            max-width: 640px;
            margin: 0 auto 32px;
            line-height: 1.6;
        }
        h2 {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 8px;
            color: #1a202c;
        }
        h3 {
            font-weight: 700;
            margin-bottom: 4px;
            font-size: 1rem;
            color: #1a202c;
        }
        .section-subtitle {
            margin-bottom: 24px;
            font-size: 0.9rem;
            color: #718096;
        }
        section {
            margin-top: 56px;
        }
        .grid-cards {
            display: grid;
            gap: 24px;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        }
        .card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px 20px 28px;
            text-align: center;
            box-shadow: 0 1px 2px rgb(0 0 0 / 0.05);
        }
        .card-icon {
            width: 46px;
            height: 46px;
            margin: 0 auto 16px;
            background: #38b2ac;
            border-radius: 999px;
            display: flex;
            justify-content: center;
            align-items: center;
            fill: white;
        }
        .card-icon svg {
            width: 22px;
            height: 22px;
        }
        .card p {
            font-size: 0.9rem;
            color: #4a5568;
            line-height: 1.5;
            margin-top: 8px;
        }

        /* seção "como funciona" */
        .steps {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            margin-top: 24px;
            text-align: left;
        }
        .step {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 18px 20px;
        }
        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 999px;
            background: linear-gradient(135deg,#38b2ac,#4299e1);
            color: #fff;
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .step h3 {
            margin-top: 0;
            margin-bottom: 6px;
        }
        .step p {
            font-size: 0.9rem;
            margin: 0;
        }

        /* seção “quem pode participar” */
        .pill-list {
            list-style: none;
            padding: 0;
            margin: 16px 0 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
        }
        .pill-list li {
            font-size: 0.85rem;
            padding: 6px 12px;
            border-radius: 999px;
            background: #e6fffa;
            color: #285e61;
        }

        /* FAQ simples */
        .faq {
            max-width: 720px;
            margin: 24px auto 0;
            text-align: left;
        }
        .faq-item {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 14px 16px;
            margin-bottom: 10px;
        }
        .faq-item strong {
            display: block;
            margin-bottom: 4px;
            color: #1a202c;
        }
        .faq-item p {
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .btn-primary {
            background-color: #38b2ac;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s ease;
            margin-top: 24px;
        }
        .btn-primary:hover {
            background-color: #2c7a7b;
        }
        .btn-primary svg {
            width: 16px;
            height: 16px;
            stroke: white;
            stroke-width: 2;
            fill: none;
        }

        footer {
            flex-direction: column;
            gap: 6px;
            font-size: 0.875rem;
            color: #718096;
        }
        footer .footer-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            color: #38b2ac;
            font-size: 18px;
            margin-bottom: 4px;
        }
        footer .footer-logo svg {
            width: 20px;
            height: 20px;
            fill: #38b2ac;
        }
    </style>
</head>
<body>
<header>
    <a href="{{ route('home') }}" class="logo" aria-label="Mutirão Amigo">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3A5.5 5.5 0 0 1 12 5.09 5.5 5.5 0 0 1 16.5 3c3.08 0 5.5 2.42 5.5 5.5 0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
        Mutirão Amigo
    </a>
    <nav>
        <a href="{{ route('home') }}" class="btn-voltar">Voltar</a>
        <a href="{{ route('sobre-nos') }}">Sobre Nós</a>
        <a href="{{ route('servicos') }}">Serviços</a>
        <a href="{{ route('internal.login') }}">Login Sistema</a>
    </nav>
</header>

<main>
    <!-- HERO -->
    <h1>
        Nossos <span class="highlight-green">Serviços</span><br/>
        <span class="highlight-blue">para o bem-estar dos animais</span>
    </h1>
    <p class="subtitle">
        Oferecemos um atendimento completo e humanizado em cada etapa: do agendamento
        à recuperação pós-operatória. Conheça os serviços disponíveis nos mutirões
        da Mutirão Amigo.
    </p>

    <!-- CARDS PRINCIPAIS (como na tela que você mandou) -->
    <section>
        <h2>Nossos Serviços</h2>
        <p class="section-subtitle">
            Cada serviço é planejado para garantir segurança, acolhimento e cuidado
            com os animais e seus tutores.
        </p>

        <div class="grid-cards">
            <div class="card">
                <div class="card-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 21c0-5-7-3-7-10s7-6 7-6 7 1 7 6-7 5-7 10z"/>
                    </svg>
                </div>
                <h3>Castração Gratuita</h3>
                <p>
                    Procedimentos cirúrgicos de castração para cães e gatos de famílias
                    de baixa renda, com critérios de triagem previamente definidos.
                </p>
            </div>

            <div class="card">
                <div class="card-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <rect x="4" y="4" width="16" height="16" rx="2"/>
                    </svg>
                </div>
                <h3>Mutirões Organizados</h3>
                <p>
                    Eventos regulares de castração em massa, em parceria com bairros,
                    ONGs e instituições que cedem espaço para atendimento.
                </p>
            </div>

            <div class="card">
                <div class="card-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                </div>
                <h3>Cuidados Pós-Operatórios</h3>
                <p>
                    Orientações detalhadas para o período de recuperação, acompanhamento
                    em casos de dúvidas e suporte em situações de emergência.
                </p>
            </div>

            <div class="card">
                <div class="card-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                </div>
                <h3>Atendimento Rápido</h3>
                <p>
                    Sistema de agendamento organizado, horários definidos e fluxo otimizado
                    para reduzir tempo de espera dos tutores e animais.
                </p>
            </div>
        </div>
    </section>

    <!-- COMO FUNCIONA O AGENDAMENTO -->
    <section>
        <h2>Como funciona o agendamento</h2>
        <p class="section-subtitle">
            Passo a passo para participar dos mutirões de castração.
        </p>

        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Pré-cadastro</h3>
                <p>
                    O tutor preenche um formulário com seus dados, do animal e do
                    bairro onde mora. Assim conseguimos organizar as vagas por região.
                </p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>Confirmação de vaga</h3>
                <p>
                    Nossa equipe entra em contato informando data, horário e local
                    do mutirão, além das orientações pré-operatórias.
                </p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Dia do mutirão</h3>
                <p>
                    O animal é recebido pela equipe, passa por triagem e segue para
                    o procedimento cirúrgico com profissionais veterinários.
                </p>
            </div>
            <div class="step">
                <div class="step-number">4</div>
                <h3>Pós-operatório</h3>
                <p>
                    Após a cirurgia, o tutor recebe todas as instruções de cuidados,
                    medicações e canais de contato para qualquer necessidade.
                </p>
            </div>
        </div>

        <button class="btn-primary" type="button">
            Agendar Castração
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <polyline points="9 18 15 12 9 6"/>
            </svg>
        </button>
    </section>

    <!-- QUEM PODE PARTICIPAR -->
    <section>
        <h2>Quem pode participar dos mutirões?</h2>
        <p class="section-subtitle">
            Nossos serviços são priorizados para tutores que mais precisam de apoio.
        </p>

        <ul class="pill-list">
            <li>Famílias de baixa renda</li>
            <li>Animais resgatados por protetores</li>
            <li>ONGs e protetores independentes parceiros</li>
            <li>Moradores das regiões atendidas em cada edição</li>
        </ul>
    </section>

    <!-- FAQ SIMPLES -->
    <section>
        <h2>Dúvidas frequentes</h2>
        <div class="faq">
            <div class="faq-item">
                <strong>O serviço é totalmente gratuito?</strong>
                <p>
                    Sim. Os procedimentos de castração realizados nos mutirões são
                    gratuitos para os tutores aprovados na triagem socioeconômica.
                </p>
            </div>
            <div class="faq-item">
                <strong>Meu animal precisa estar em jejum?</strong>
                <p>
                    Sim. Antes do mutirão você receberá todas as orientações de jejum e
                    cuidados necessários para garantir a segurança do procedimento.
                </p>
            </div>
            <div class="faq-item">
                <strong>Posso castrar mais de um animal?</strong>
                <p>
                    Em muitos casos é possível, mas as vagas são limitadas. Nossa equipe
                    verifica cada pedido conforme a disponibilidade de cada mutirão.
                </p>
            </div>
        </div>
    </section>
</main>

<footer>
    <div class="footer-logo" aria-label="Logotipo Mutirão Amigo">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3A5.5 5.5 0 0 1 12 5.09 5.5 5.5 0 0 1 16.5 3c3.08 0 5.5 2.42 5.5 5.5 0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
        Mutirão Amigo
    </div>
    <div>ONG dedicada ao bem-estar animal através da castração responsável</div>
    <div>© 2024 Mutirão Amigo. Todos os direitos reservados.</div>
</footer>
</body>
</html>
