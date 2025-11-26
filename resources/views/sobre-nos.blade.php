<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mutirão Amigo - Sobre Nós</title>
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
            padding: 0 20px;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 16px;
            font-weight: 900;
            line-height: 1.2;
            text-align: center;
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
            max-width: 720px;
            margin: 0 auto 32px;
            line-height: 1.6;
            text-align: center;
        }
        section {
            margin-top: 48px;
        }
        h2 {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 12px;
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
        .grid-two-columns {
            display: grid;
            gap: 32px;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1.5fr);
        }
        .grid-cards {
            display: grid;
            gap: 24px;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        .card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            text-align: left;
            box-shadow: 0 1px 2px rgb(0 0 0 / 0.05);
        }
        .card-icon {
            width: 40px;
            height: 40px;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #38b2ac 0%, #4299e1 100%);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            fill: white;
        }
        .card-icon svg {
            width: 20px;
            height: 20px;
        }
        .card-number {
            font-size: 1.4rem;
            font-weight: 800;
            color: #38b2ac;
            margin-bottom: 4px;
        }
        .card-text {
            font-size: 0.9rem;
            color: #4a5568;
        }
        .about-text p {
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 12px;
        }
        .pill-list {
            list-style: none;
            padding: 0;
            margin: 12px 0 0;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .pill-list li {
            font-size: 0.8rem;
            padding: 6px 10px;
            border-radius: 999px;
            background: #e6fffa;
            color: #285e61;
        }
        .values-list {
            list-style: none;
            padding: 0;
            margin: 8px 0 0;
        }
        .values-list li {
            font-size: 0.9rem;
            color: #4a5568;
            margin-bottom: 6px;
            display: flex;
            gap: 8px;
        }
        .values-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: linear-gradient(135deg, #38b2ac 0%, #4299e1 100%);
            margin-top: 7px;
            flex-shrink: 0;
        }
        .footer-cta {
            background: linear-gradient(135deg, #4299e1 0%, #38b2ac 100%);
            color: white;
            padding: 32px 20px;
            margin-top: 64px;
            border-radius: 8px;
            text-align: center;
        }
        .footer-cta h2 {
            font-size: 1.5rem;
            margin-bottom: 8px;
            font-weight: 700;
        }
        .footer-cta p {
            max-width: 600px;
            margin: 0 auto 20px;
            font-weight: 500;
            font-size: 1rem;
        }
        .footer-cta button {
            padding: 12px 28px;
            border-radius: 6px;
            border: none;
            background: #e2e8f0;
            color: #2d3748;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .footer-cta button:hover {
            background-color: #cbd5e0;
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

        @media (max-width: 768px) {
            .grid-two-columns {
                grid-template-columns: 1fr;
            }
            h1, p.subtitle {
                text-align: center;
            }
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
            <a href="{{ route('home') }}#servicos">Serviços</a>
        </nav>
    </header>

    <main>
        <!-- HERO SOBRE NÓS -->
        <h1>
            Sobre a <span class="highlight-green">Mutirão Amigo</span><br/>
            <span class="highlight-blue">Nossa história e propósito</span>
        </h1>
        <p class="subtitle">
            Somos uma ONG que há mais de 8 anos organiza mutirões de castração gratuita,
            conectando veterinários, voluntários e tutores que acreditam em um futuro mais
            digno para cães e gatos da comunidade.
        </p>

        <!-- QUEM SOMOS + MISSÃO/VISÃO/VALORES -->
        <section>
            <h2>Quem Somos</h2>

            <div class="about-text">
                <p>
                    A Mutirão Amigo nasceu da união de protetores independentes que viam
                    a realidade de animais em situação de risco e a dificuldade de muitas
                    famílias em arcar com procedimentos de castração.
                </p>
                <p>
                    Desde então, organizamos mutirões em diferentes bairros, sempre com
                    foco em atendimento humanizado, orientação clara aos tutores e
                    respeito ao bem-estar animal antes, durante e depois da cirurgia.
                </p>
                <p>
                    Ao longo dos anos construímos uma rede de voluntários, parceiros e
                    apoiadores que acreditam que castrar é um ato de amor e
                    responsabilidade com toda a comunidade.
                </p>
            </div>

            <!-- AGORA OS CARDS VÊM EMBAIXO DO TEXTO -->
            <div class="grid-cards" style="margin-top:24px;">
                <div class="card">
                    <div class="card-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 21c0-5-7-3-7-10s7-6 7-6 7 1 7 6-7 5-7 10z"/>
                        </svg>
                    </div>
                    <h3>Missão</h3>
                    <p class="card-text">
                        Promover o controle populacional e o bem-estar de cães e gatos,
                        oferecendo castração acessível e educação em guarda responsável.
                    </p>
                </div>

                <div class="card">
                    <div class="card-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 8l-3 3h6l-3 5"/>
                        </svg>
                    </div>
                    <h3>Visão</h3>
                    <p class="card-text">
                        Ser referência em mutirões de castração solidária e em ações
                        que aproximem pessoas, poder público e iniciativas privadas
                        na proteção animal.
                    </p>
                </div>

                <div class="card">
                    <div class="card-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3A5.5 5.5 0 0 1 12 5.09 5.5 5.5 0 0 1 16.5 3c3.08 0 5.5 2.42 5.5 5.5 0 3.78-3.4 6.86-8.55 11.54z"/>
                        </svg>
                    </div>
                    <h3>Valores</h3>
                    <ul class="values-list">
                        <li><span class="values-dot"></span>Respeito à vida e ao bem-estar animal.</li>
                        <li><span class="values-dot"></span>Transparência e responsabilidade com recursos.</li>
                        <li><span class="values-dot"></span>Empatia com tutores e comunidade.</li>
                        <li><span class="values-dot"></span>Trabalho em equipe e voluntariado.</li>
                    </ul>
                </div>
            </div>
        </section>


        <!-- COMO ATUAMOS / IMPACTO NUMÉRICO -->
        <section>
            <h2>Como Atuamos</h2>
            <p class="section-subtitle">
                Organizamos mutirões planejados para oferecer atendimento seguro, ágil e acolhedor
                para animais e tutores.
            </p>

            <div class="grid-cards">
                <div class="card">
                    <h3>Planejamento dos mutirões</h3>
                    <p class="card-text">
                        Definimos datas, locais parceiros e equipe voluntária. Cada evento conta
                        com estrutura mínima para triagem, cirurgia e recuperação imediata.
                    </p>
                </div>
                <div class="card">
                    <h3>Cadastro e triagem</h3>
                    <p class="card-text">
                        Os tutores realizam cadastro antecipado e passam por triagem socioeconômica
                        e clínica, garantindo prioridade para quem mais precisa.
                    </p>
                </div>
                <div class="card">
                    <h3>Cirurgia e cuidados</h3>
                    <p class="card-text">
                        Veterinários parceiros realizam as cirurgias com protocolos seguros, enquanto
                        a equipe de apoio orienta e acompanha cada animal.
                    </p>
                </div>
                <div class="card">
                    <h3>Pós-operatório e orientação</h3>
                    <p class="card-text">
                        Após o mutirão, os tutores recebem instruções detalhadas e canais de contato
                        para qualquer dúvida durante a recuperação.
                    </p>
                </div>
            </div>
        </section>

        <section>
            <h2>Nosso Impacto em Números</h2>
            <p class="section-subtitle">
                Resultados que reforçam a importância de cada mutirão realizado.
            </p>
            <div class="grid-cards">
                <div class="card">
                    <div class="card-number">2.847</div>
                    <div class="card-text">Animais castrados ao longo dos anos.</div>
                </div>
                <div class="card">
                    <div class="card-number">1.234</div>
                    <div class="card-text">Tutores atendidos e orientados.</div>
                </div>
                <div class="card">
                    <div class="card-number">47</div>
                    <div class="card-text">Mutirões organizados pela ONG.</div>
                </div>
                <div class="card">
                    <div class="card-number">8</div>
                    <div class="card-text">Anos de atuação contínua.</div>
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
