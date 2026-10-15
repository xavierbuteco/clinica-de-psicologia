<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Painel do Psicólogo</title>
<style>
body { font-family: sans-serif; padding: 40px; background: #f4f7f6; }
.card { max-width: 700px; margin: auto; background: white; padding: 30px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
h1 { color: #1a3b3e; }
</style>
</head>
<body>
<div class="card">
<h1>Painel do Psicólogo</h1>
<p><strong>Pacientes vinculados:</strong> {{ $totalPacientes }}</p>
<p><strong>Consultas pendentes:</strong> {{ $consultasPendentes }}</p>
<p><strong>Consultas da semana:</strong> {{ $consultasSemana }}</p>
<p><strong>Consultas sem feedback:</strong> {{ $consultasSemFeedback }}</p>
<h3>Próximas consultas</h3>
<ul>
@foreach ($proximasConsultas as $c)
<li>{{ $c->paciente->nome ?? 'Paciente' }} — {{ $c->data }} {{ $c->hora }}</li>
@endforeach
</ul>
</div>
</body>
</html>
