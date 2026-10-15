<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle</title>
    <!-- Google Fonts para consistência tipográfica -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: radial-gradient(circle at 50% 50%, #f4f7f6 0%, #e9f0ee 100%);
            padding: 20px;
        }

        .card {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 15px 35px rgba(12, 84, 96, 0.06), 0px 1px 5px rgba(0, 0, 0, 0.02);
            width: 100%;
            max-width: 500px;
            text-align: center;
            border: 1px solid rgba(12, 84, 96, 0.08);
            position: relative;
            overflow: hidden;
        }

        /* Linha decorativa no topo para dar o charme do tema saúde */
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #4a9e91, #7ec4b9);
        }

        /* Badges de perfil refinados */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 24px;
            letter-spacing: 0.3px;
        }

        .badge-psicologo {
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        .badge-paciente {
            background-color: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        h1 {
            color: #1a3b3e;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 12px;
            line-height: 1.2;
        }

        p {
            color: #5c757a;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Botão de ação com relevo suave e transição */
        .btn-action {
            display: inline-block;
            width: 100%;
            padding: 16px 24px;
            background-color: #4a9e91;
            color: #ffffff;
            text-decoration: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 12px rgba(74, 158, 145, 0.15);
        }

        .btn-action:hover {
            background-color: #3b8277;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(74, 158, 145, 0.25);
        }

        .btn-action:active {
            transform: translateY(0);
        }

        hr {
            border: 0;
            border-top: 1px solid #eef2f1;
            margin: 28px 0;
        }

        /* Botão de sair refinado (cinza-vermelho sutil) */
        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background-color: #fcf8f8;
            color: #b91c1c;
            border: 1px solid #fee2e2;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background-color: #fef2f2;
            color: #991b1b;
            border-color: #fca5a5;
        }
    </style>
</head>
<body>
    <div class="card">
        {{-- Badge indicando o tipo de usuário conectado --}}
        @if ($tipoUsuario === 'psicologo')
            <span class="badge badge-psicologo">🩺 Perfil: Psicólogo(a)</span>
        @else
            <span class="badge badge-paciente">👤 Perfil: Paciente</span>
        @endif

        <h1>Olá, {{ $nomeUsuario }}!</h1>

        {{-- Conteúdo dinâmico dependendo do tipo do usuário --}}
        @if ($tipoUsuario === 'psicologo')
            <p>Bem vindo otario, agora vamo trabalhar porque a vida não é um morango, tu é CLT e o Brasil foi eliminado da copa.</p>
            <a href="{{ route('painel.psicologo') }}" class="btn-action">📅 Acessar Minha Agenda</a>
        @else
            <p>boas vinda desempregado falido, agenda a tua consulta porque de tristeza tu ja passa pela tua ex e pela seleção, agende a tua consulta agora.</p>
            <a href="{{ route('consultas.index') }}" class="...">Agendar Nova Consulta</a>
        @endif

        <hr>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <span>🚪</span> Sair da Conta
            </button>
        </form>
    </div>
</body>
</html>
