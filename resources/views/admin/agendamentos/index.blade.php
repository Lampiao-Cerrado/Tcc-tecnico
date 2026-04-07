@extends('admin.layout')

@section('title', 'Agendamentos')

@section('content')
<h1>Agendamentos</h1>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome (criptografado)</th>
            <th>Data</th>
            <th>Enviado em</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>—</td>
            <td>—</td>
            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <a href="{{ route('admin.agendamentos.show', $item) }}" class="btn">Ver</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $items->links() }}
@endsection
