@extends('admin.layout')

@section('title', 'Currículos')

@section('content')
<h1>Currículos enviados</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Enviado em</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->id }}</td>

            {{-- DESCRIPTOGRAFIA DIRETA NO ADMIN --}}
            <td>{{ decrypt_aes($item->nome) }}</td>
            <td>{{ decrypt_aes($item->email) }}</td>

            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>

            <td>
                <a href="{{ route('admin.curriculos.show', $item->id) }}" class="btn btn-primary btn-sm">
                    Ver
                </a>

                <a href="{{ route('admin.curriculos.download', $item->id) }}" class="btn btn-success btn-sm">
                    PDF
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $items->links() }}
</div>
@endsection
