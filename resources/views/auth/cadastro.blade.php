<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>

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
            max-width: 400px;
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
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #3e5a5e;
            margin-bottom: 6px;
        }

        input, select {
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

        input:focus, select:focus {
            background-color: #ffffff;
            border-color: #4a9e91;
            box-shadow: 0 0 0 4px rgba(74, 158, 145, 0.12);
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%233e5a5e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            cursor: pointer;
        }

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

        #campo-crp {
            display: none;
            animation: slideDown 0.30s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .password-requirements {
            margin-top: 6px;
            font-size: 11px;
            color: #627d82;
            line-height: 1.4;
        }
        .requirement {
            display: inline-block;
            margin-right: 8px;
            transition: color 0.2s ease;
        }
        .requirement.valid {
            color: #15803d;
        }
        .requirement.invalid {
            color: #ec5959;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>Criar Conta</h2>
        <p class="subtitle">Faça seu cadastro para começar</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('sucesso'))
            <div class="alert alert-danger" style="background-color:#f0faf7;color:#15803d;border-color:#bfe8d9;">
                {{ session('sucesso') }}
            </div>
        @endif

        <form method="POST" action="{{ route('cadastro.store') }}" id="cadastroForm">
            @csrf

            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" placeholder="Ex: Maria Souza" value="{{ old('nome') }}" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="nome@exemplo.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha"
                       placeholder="Crie uma senha forte"
                       pattern="^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$"
                       title="A senha deve ter no mínimo 8 caracteres, incluindo pelo menos uma letra maiúscula, um número e um caractere especial."
                       required>

                <div class="password-requirements" id="password-reqs">
                    <span id="req-length" class="requirement">• Mín. 8 caracteres</span>
                    <span id="req-upper" class="requirement">• Letra maiúscula</span>
                    <span id="req-num" class="requirement">• Número</span>
                    <span id="req-special" class="requirement">• Caractere especial (!@#$...)</span>
                </div>
            </div>

            <div class="form-group">
                <label for="tipo_usuario">Tipo de Perfil</label>
                <select name="tipo_usuario" id="tipo_usuario" onchange="toggleCRP()" required>
                    <option value="paciente" {{ old('tipo_usuario') === 'paciente' ? 'selected' : '' }}>Quero agendar consultas (Paciente)</option>
                    <option value="psicologo" {{ old('tipo_usuario') === 'psicologo' ? 'selected' : '' }}>Quero atender pacientes (Psicólogo)</option>
                </select>
            </div>

            <div id="campo-crp" class="form-group">
                <label for="crp_input">CRP (Conselho Regional de Psicologia)</label>
                <input type="text" name="crp" id="crp_input" placeholder="06/123456" maxlength="9" value="{{ old('crp') }}">
            </div>

            <button type="submit">Finalizar Cadastro</button>
        </form>

        <a href="{{ route('login') }}" class="footer-link">Já tem uma conta? Fazer Login</a>
    </div>

    <script>
        function toggleCRP() {
            var select = document.getElementById('tipo_usuario');
            var campoCRP = document.getElementById('campo-crp');
            var inputCRP = document.getElementById('crp_input');

            if (select.value === 'psicologo') {
                campoCRP.style.display = 'block';
                inputCRP.setAttribute('required', 'required');
                inputCRP.focus();
            } else {
                campoCRP.style.display = 'none';
                inputCRP.removeAttribute('required');
                inputCRP.value = '';
            }
        }

        document.getElementById('crp_input').addEventListener('input', function (e) {
            var value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 8);
            }
            e.target.value = value;
        });

        const passwordInput = document.getElementById('senha');
        const reqLength = document.getElementById('req-length');
        const reqUpper = document.getElementById('req-upper');
        const reqNum = document.getElementById('req-num');
        const reqSpecial = document.getElementById('req-special');

        passwordInput.addEventListener('input', function() {
            const val = passwordInput.value;

            reqLength.className = val.length >= 8 ? 'requirement valid' : 'requirement invalid';
            reqUpper.className = /[A-Z]/.test(val) ? 'requirement valid' : 'requirement invalid';
            reqNum.className = /[0-9]/.test(val) ? 'requirement valid' : 'requirement invalid';
            reqSpecial.className = /[\W_]/.test(val) ? 'requirement valid' : 'requirement invalid';

            if (val === '') {
                document.querySelectorAll('.requirement').forEach(el => el.className = 'requirement');
            }
        });

        // Mantém o valor do tipo_usuario selecionado ao recarregar a página (old())
        document.addEventListener('DOMContentLoaded', toggleCRP);
    </script>
</body>
</html>
