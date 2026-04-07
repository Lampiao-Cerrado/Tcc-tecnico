@extends('site.layout')

@section('title', 'Recuperar Senha')

@section('content')
<main class="loginTeste">

    <div class="login-container">

        <h1>Recuperar Senha</h1>

        {{-- Mensagens de sucesso --}}
        @if(session('status'))
            <div class="alert-login-sucesso">
                {{ session('status') }}
            </div>
        @endif

        {{-- Erros --}}
        @if($errors->any())
            <div class="alert-login-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.enviarLink') }}">
            @csrf

            <label for="email">E-mail do administrador</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}">

            <button type="submit">Enviar link de recuperação</button>
        </form>

        <div class="voltar-site" style="margin-top: 15px;">
            <a href="{{ route('admin.login') }}">← Voltar ao login</a>
        </div>

    </div>

</main>
@endsection
