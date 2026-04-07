@extends('admin.layout')

@section('title', 'Detalhes do currículo')

@section('content')
<h1>Currículo #{{ $item->id }}</h1>

<div class="card p-4">
    <p><strong>Nome:</strong> {{ decrypt_aes($item->nome) }}</p>
    <p><strong>Email:</strong> {{ decrypt_aes($item->email) }}</p>
    <p><strong>Telefone:</strong> {{ decrypt_aes($item->telefone) }}</p>
    <p><strong>Mensagem:</strong> {{ decrypt_aes($item->mensagem) }}</p>

    <p><strong>Currículo enviado:</strong></p>
    <a href="{{ route('admin.curriculos.download', $item->id) }}" class="btn btn-success">
        Baixar PDF
    </a>

    <br><br>
    <a href="{{ route('admin.curriculos.index') }}" class="btn btn-secondary">Voltar</a>
</div>
@endsection
