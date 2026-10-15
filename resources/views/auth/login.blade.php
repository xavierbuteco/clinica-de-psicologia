<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Acessar Sistema</title>
    <!-- Google Fonts para uma tipografia moderna e idêntica à do cadastro -->
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

        .box {
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0px 10px 30px rgba(12, 84, 96, 0.05), 0px 1px 3px rgba(0, 0, 0, 0.02);
            width: 100%;
            max-width: 380px;
            border: 1px solid rgba(12, 84, 96, 0.08);
        }

        h2 {
            color: #1a3b3e;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
            text-align: center;
        }

        .subtitle {
            color: #627d82;
            font-size: 14px;
            text-align: center;
            margin-bottom: 24px;
        }

        /* Alerta de erro estilizado */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
            line-height: 1.5;
            text-align: center;
        }
        .alert-danger {
            background-color: #fdf2f2;
            color: #ec5959;
            border: 1px solid #fbd5d5;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #3e5a5e;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 12px 16px;
            font-size: 14px;
            color: #1a3b3e;
            background-color: #f8faf9;
            border: 1px solid #d1dbd9;
            border-radius: 8px;
            transition: all 0.25s ease;
            outline: none;
        }

        input::placeholder {
            color: #9cb1af;
        }

        /* Efeito de Foco nos Inputs */
        input:focus {
            background-color: #ffffff;
            border-color: #4a9e91;
            box-shadow: 0 0 0 4px rgba(74, 158, 145, 0.12);
        }

        /* Botão de Entrada */
        button {
            width: 100%;
            padding: 14px;
            background-color: #4a9e91;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: #3b8277;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(74, 158, 145, 0.2);
        }

        button:active {
            transform: translateY(0);
        }

        /* Link para a tela de cadastro */
        .footer-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            color: #4a9e91;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-link:hover {
            color: #2c6158;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>Acessar Sistema</h2>
        <p class="subtitle">Insira suas credenciais para entrar</p>

        @if (session('sucesso'))
            <div class="alert alert-danger" style="background-color:#f0faf7;color:#15803d;border-color:#bfe8d9;">
                {{ session('sucesso') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="nome@exemplo.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>

            <button type="submit">Entrar</button>
        </form>

        <a href="{{ route('cadastro') }}" class="footer-link">Não tem uma conta? Cadastre-se</a>
    </div>
</body>
</html>
