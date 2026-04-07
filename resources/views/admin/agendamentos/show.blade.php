@extends('admin.layout')

@section('title', 'Agendamento')

@section('content')

<h1>Agendamento #{{ $agendamento->id }}</h1>

<div class="card">
    <p><strong>Nome:</strong> {{ $nome }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Telefone:</strong> {{ $telefone }}</p>
    <p><strong>Data:</strong> {{ $data }}</p>
    <p><strong>Hora:</strong> {{ $hora }}</p>
    <p><strong>Mensagem:</strong> {{ $mensagem }}</p>
</div>

<a href="{{ route('admin.agendamentos.index') }}" class="btn">Voltar</a>

@endsection
