<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agendar Nova Consulta</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            min-height: 100vh;
            background: radial-gradient(circle at 50% 0%, #f4f7f6 0%, #e9f0ee 100%);
            padding: 24px;
            color: #1a3b3e;
        }

        .topo {
            max-width: 1200px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topo h1 {
            font-size: 24px;
            font-weight: 700;
        }

        .topo a {
            color: #4a9e91;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .topo a:hover {
            text-decoration: underline;
        }

        .layout {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 260px 1fr 340px;
            grid-template-areas:
                "calendario agendamento chat"
                "calendario consultas feedbacks";
            gap: 20px;
            align-items: start;
        }

        .painel-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0px 10px 30px rgba(12, 84, 96, 0.05), 0px 1px 3px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(12, 84, 96, 0.08);
        }

        .painel-box h2 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #1a3b3e;
        }

        /* ---------- Calendário ---------- */
        #calendario-box { grid-area: calendario; }

        .cal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .cal-header button {
            background: none;
            border: none;
            color: #4a9e91;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .cal-header button:hover { background: #eef6f4; }

        .cal-mes { font-size: 14px; font-weight: 600; }

        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            text-align: center;
        }

        .cal-grid .dia-semana {
            font-size: 10px;
            font-weight: 700;
            color: #9cb1af;
            padding-bottom: 4px;
        }

        .cal-dia {
            position: relative;
            font-size: 12px;
            padding: 7px 0;
            border-radius: 8px;
            cursor: pointer;
            color: #3e5a5e;
        }

        .cal-dia:hover { background: #eef6f4; }
        .cal-dia.vazio { cursor: default; }
        .cal-dia.vazio:hover { background: none; }
        .cal-dia.hoje { border: 1px solid #4a9e91; font-weight: 700; }
        .cal-dia.selecionado { background: #4a9e91; color: #fff; font-weight: 700; }
        .cal-dia.tem-consulta::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #ec5959;
        }
        .cal-dia.selecionado.tem-consulta::after { background: #fff; }

        /* ---------- Formulário de agendamento ---------- */
        #agendamento-box { grid-area: agendamento; }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 16px;
            text-align: center;
        }
        .alert-danger { background: #fdf2f2; color: #ec5959; border: 1px solid #fbd5d5; }
        .alert-sucesso { background: #f0faf7; color: #15803d; border: 1px solid #bfe8d9; }

        .form-row { display: flex; gap: 12px; }
        .form-group { margin-bottom: 14px; flex: 1; }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #3e5a5e;
            margin-bottom: 6px;
        }

        input, select, textarea {
            width: 100%;
            padding: 11px 14px;
            font-size: 14px;
            color: #1a3b3e;
            background-color: #f8faf9;
            border: 1px solid #d1dbd9;
            border-radius: 8px;
            outline: none;
            transition: all 0.2s ease;
        }

        textarea { resize: vertical; min-height: 70px; }

        input:focus, select:focus, textarea:focus {
            background-color: #ffffff;
            border-color: #4a9e91;
            box-shadow: 0 0 0 4px rgba(74, 158, 145, 0.12);
        }

        button.btn-primary {
            width: 100%;
            padding: 13px;
            background-color: #4a9e91;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 4px;
        }

        button.btn-primary:hover { background-color: #3b8277; }

        /* ---------- Lista de consultas ---------- */
        #consultas-box { grid-area: consultas; }

        .consulta-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 12px 0;
            border-bottom: 1px solid #eef2f1;
            font-size: 13px;
        }
        .consulta-item:last-child { border-bottom: none; }

        .consulta-info strong { display: block; color: #1a3b3e; font-size: 14px; }
        .consulta-info span { color: #627d82; font-size: 12px; }

        .badge-status {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            white-space: nowrap;
        }
        .status-agendada { background: #e0f2fe; color: #0369a1; }
        .status-concluida { background: #ecfdf5; color: #047857; }
        .status-cancelada { background: #fdf2f2; color: #ec5959; }

        .vazio-lista { color: #9cb1af; font-size: 13px; text-align: center; padding: 20px 0; }

        /* ---------- Chat ---------- */
        #chat-box { grid-area: chat; display: flex; flex-direction: column; }

        #chat-mensagens {
            flex: 1;
            height: 260px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 12px;
            padding-right: 4px;
        }

        .msg {
            max-width: 80%;
            padding: 8px 12px;
            border-radius: 12px;
            font-size: 13px;
            line-height: 1.4;
        }
        .msg-deles { align-self: flex-start; background: #f1f5f4; color: #1a3b3e; border-bottom-left-radius: 2px; }
        .msg-minha { align-self: flex-end; background: #4a9e91; color: #fff; border-bottom-right-radius: 2px; }
        .msg small { display: block; margin-top: 3px; opacity: 0.7; font-size: 10px; }

        #chat-form { display: flex; gap: 8px; }
        #chat-form input { flex: 1; }
        #chat-form button {
            background: #4a9e91;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0 16px;
            font-weight: 600;
            cursor: pointer;
        }
        #chat-form button:hover { background: #3b8277; }

        .sem-psicologo { color: #9cb1af; font-size: 13px; text-align: center; padding: 30px 0; }

        /* ---------- Feedbacks ---------- */
        #feedbacks-box { grid-area: feedbacks; max-height: 340px; overflow-y: auto; }

        .feedback-item { padding: 12px 0; border-bottom: 1px solid #eef2f1; }
        .feedback-item:last-child { border-bottom: none; }

        .badge-tipo {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .tipo-feedback { background: #e0f2fe; color: #0369a1; }
        .tipo-ressalva { background: #fef3c7; color: #92400e; }
        .tipo-lembrete { background: #ede9fe; color: #6d28d9; }

        .feedback-item p { font-size: 13px; color: #3e5a5e; line-height: 1.5; }
        .feedback-item .feedback-meta { font-size: 11px; color: #9cb1af; margin-top: 4px; }

        @media (max-width: 980px) {
            .layout {
                grid-template-columns: 1fr;
                grid-template-areas:
                    "calendario"
                    "agendamento"
                    "consultas"
                    "chat"
                    "feedbacks";
            }
        }
    </style>
</head>
<body>

    <div class="topo">
        <h1>Nova Consulta</h1>
        <a href="{{ route('painel') }}">← Voltar ao painel</a>
    </div>

    <div class="layout">

        {{-- ===================== CALENDÁRIO (esquerda) ===================== --}}
        <div class="painel-box" id="calendario-box">
            <h2>Calendário</h2>
            <div class="cal-header">
                <button type="button" id="cal-anterior">‹</button>
                <span class="cal-mes" id="cal-mes-label"></span>
                <button type="button" id="cal-proximo">›</button>
            </div>
            <div class="cal-grid" id="cal-dias-semana"></div>
            <div class="cal-grid" id="cal-dias" style="margin-top: 4px;"></div>
        </div>

        {{-- ===================== FORM DE AGENDAMENTO (meio, topo) ===================== --}}
        <div class="painel-box" id="agendamento-box">
            <h2>Agendar Consulta</h2>

            @if (session('sucesso'))
                <div class="alert alert-sucesso">{{ session('sucesso') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('consultas.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="data">Data</label>
                        <input type="date" id="data" name="data" value="{{ old('data') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="hora">Horário</label>
                        <input type="time" id="hora" name="hora" value="{{ old('hora') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="tipo_consulta">Tipo de Consulta</label>
                    <select id="tipo_consulta" name="tipo_consulta" required>
                        <option value="">Selecione...</option>
                        @foreach ($tiposConsulta as $valor => $rotulo)
                            <option value="{{ $valor }}" {{ old('tipo_consulta') === $valor ? 'selected' : '' }}>
                                {{ $rotulo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="laudo">Laudo (opcional)</label>
                    <input type="file" id="laudo" name="laudo" accept=".pdf,.jpg,.jpeg,.png">
                </div>

                <div class="form-group">
                    <label for="observacoes">Observações</label>
                    <textarea id="observacoes" name="observacoes" placeholder="Conte um pouco sobre o motivo da consulta...">{{ old('observacoes') }}</textarea>
                </div>

                <button type="submit" class="btn-primary">Confirmar Agendamento</button>
            </form>
        </div>

        {{-- ===================== LISTA DE CONSULTAS (meio, baixo) ===================== --}}
        <div class="painel-box" id="consultas-box">
            <h2>Minhas Consultas Agendadas</h2>

            @forelse ($consultasAgendadas as $consulta)
                <div class="consulta-item">
                    <div class="consulta-info">
                        <strong>{{ $tiposConsulta[$consulta->tipo_consulta] ?? $consulta->tipo_consulta }}</strong>
                        <span>
                            {{ $consulta->data->format('d/m/Y') }} às {{ \Illuminate\Support\Carbon::parse($consulta->hora)->format('H:i') }}
                            @if ($consulta->psicologo)
                                · Dr(a). {{ $consulta->psicologo->nome }}
                            @endif
                            @if ($consulta->laudo_path)
                                · 📎 Laudo anexado
                            @endif
                        </span>
                    </div>
                    <span class="badge-status status-{{ $consulta->status }}">
                        {{ ucfirst($consulta->status) }}
                    </span>
                </div>
            @empty
                <p class="vazio-lista">Você ainda não tem consultas agendadas.</p>
            @endforelse
        </div>

        {{-- ===================== CHAT (direita, topo) ===================== --}}
        <div class="painel-box" id="chat-box">
            <h2>💬 Chat com o Psicólogo</h2>

            @if ($psicologo)
                <p style="font-size:12px;color:#627d82;margin-bottom:10px;">
                    Conversando com Dr(a). {{ $psicologo->nome }}
                </p>
                <div id="chat-mensagens"></div>
                <form id="chat-form" data-destinatario-id="{{ $psicologo->id }}">
                    <input type="text" id="chat-input" placeholder="Escreva sua mensagem..." autocomplete="off" required>
                    <button type="submit">Enviar</button>
                </form>
            @else
                <p class="sem-psicologo">Nenhum psicólogo disponível para chat no momento.</p>
            @endif
        </div>

        {{-- ===================== FEEDBACKS (direita, baixo) ===================== --}}
        <div class="painel-box" id="feedbacks-box">
            <h2>Feedbacks, Ressalvas e Lembretes</h2>

            @forelse ($feedbacks as $feedback)
                <div class="feedback-item">
                    <span class="badge-tipo tipo-{{ $feedback->tipo }}">
                        {{ \App\Models\Feedback::rotulosTipo()[$feedback->tipo] ?? $feedback->tipo }}
                    </span>
                    <p>{{ $feedback->conteudo }}</p>
                    <div class="feedback-meta">
                        Dr(a). {{ $feedback->psicologo->nome }}
                        @if ($feedback->consulta)
                            · consulta de {{ $feedback->consulta->data->format('d/m/Y') }}
                        @endif
                    </div>
                </div>
            @empty
                <p class="vazio-lista">Nenhum feedback registrado ainda.</p>
            @endforelse
        </div>

    </div>

    <script>
        // ============== CALENDÁRIO ==============
        (function () {
            const diasSemana = ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'];
            const nomesMeses = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];

            // Datas (YYYY-MM-DD) em que o paciente já tem consulta marcada.
      // Substitua a linha antiga por esta:
const datasComConsulta = JSON.parse('{!! json_encode($datasConsultasFormatted) !!}');

            const hoje = new Date();
            let mesAtual = hoje.getMonth();
            let anoAtual = hoje.getFullYear();
            let dataSelecionada = null;

            const semanaEl = document.getElementById('cal-dias-semana');
            diasSemana.forEach(d => {
                const el = document.createElement('div');
                el.className = 'dia-semana';
                el.textContent = d;
                semanaEl.appendChild(el);
            });

            function pad(n) { return n < 10 ? '0' + n : '' + n; }

            function renderCalendario() {
                document.getElementById('cal-mes-label').textContent = `${nomesMeses[mesAtual]} ${anoAtual}`;
                const diasEl = document.getElementById('cal-dias');
                diasEl.innerHTML = '';

                const primeiroDiaSemana = new Date(anoAtual, mesAtual, 1).getDay();
                const totalDias = new Date(anoAtual, mesAtual + 1, 0).getDate();

                for (let i = 0; i < primeiroDiaSemana; i++) {
                    const vazio = document.createElement('div');
                    vazio.className = 'cal-dia vazio';
                    diasEl.appendChild(vazio);
                }

                for (let dia = 1; dia <= totalDias; dia++) {
                    const isoData = `${anoAtual}-${pad(mesAtual + 1)}-${pad(dia)}`;
                    const el = document.createElement('div');
                    el.className = 'cal-dia';
                    el.textContent = dia;
                    el.dataset.data = isoData;

                    if (isoData === hoje.toISOString().slice(0, 10)) {
                        el.classList.add('hoje');
                    }
                    if (datasComConsulta.includes(isoData)) {
                        el.classList.add('tem-consulta');
                    }
                    if (isoData === dataSelecionada) {
                        el.classList.add('selecionado');
                    }

                    el.addEventListener('click', () => {
                        dataSelecionada = isoData;
                        document.getElementById('data').value = isoData;
                        renderCalendario();
                    });

                    diasEl.appendChild(el);
                }
            }

            document.getElementById('cal-anterior').addEventListener('click', () => {
                mesAtual--;
                if (mesAtual < 0) { mesAtual = 11; anoAtual--; }
                renderCalendario();
            });

            document.getElementById('cal-proximo').addEventListener('click', () => {
                mesAtual++;
                if (mesAtual > 11) { mesAtual = 0; anoAtual++; }
                renderCalendario();
            });

            renderCalendario();
        })();

        // ============== CHAT (polling simples via fetch) ==============
        (function () {
            const form = document.getElementById('chat-form');
            if (!form) return;

            const destinatarioId = form.dataset.destinatarioId;
            const mensagensEl = document.getElementById('chat-mensagens');
            const inputEl = document.getElementById('chat-input');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            let ultimoId = 0;

            function renderMensagem(msg) {
                const bolha = document.createElement('div');
                bolha.className = 'msg ' + (msg.de_mim ? 'msg-minha' : 'msg-deles');
                bolha.innerHTML = `${msg.mensagem}<small>${msg.criada_em}</small>`;
                mensagensEl.appendChild(bolha);
                if (msg.id > ultimoId) ultimoId = msg.id;
            }

            async function carregarMensagens() {
                try {
                    const params = new URLSearchParams({ destinatario_id: destinatarioId, apos_id: ultimoId });
                    const resp = await fetch(`{{ route('chat.index') }}?${params.toString()}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (!resp.ok) return;
                    const dados = await resp.json();
                    const estavaNoFim = mensagensEl.scrollTop + mensagensEl.clientHeight >= mensagensEl.scrollHeight - 10;
                    dados.mensagens.forEach(renderMensagem);
                    if (estavaNoFim) mensagensEl.scrollTop = mensagensEl.scrollHeight;
                } catch (e) {
                    console.error('Erro ao carregar mensagens', e);
                }
            }

            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                const texto = inputEl.value.trim();
                if (!texto) return;

                inputEl.value = '';
                try {
                    const resp = await fetch(`{{ route('chat.store') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ destinatario_id: destinatarioId, mensagem: texto }),
                    });
                    if (!resp.ok) return;
                    const dados = await resp.json();
                    renderMensagem(dados.mensagem);
                    mensagensEl.scrollTop = mensagensEl.scrollHeight;
                } catch (e) {
                    console.error('Erro ao enviar mensagem', e);
                }
            });

            carregarMensagens();
            setInterval(carregarMensagens, 4000);
        })();
    </script>
</body>
</html>