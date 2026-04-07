@extends('site.layout')

@section('title', 'Redefinir Senha')

@section('content')
<main class="loginTeste">

    <div class="login-container">

        <h1>Redefinir Senha</h1>

        {{-- Mensagem de erro / token inválido --}}
        @if($errors->any())
            <div class="alert-login-error">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Mensagem de sucesso --}}
        @if(session('status'))
            <div class="alert-login-sucesso">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.salvarSenha') }}">
            @csrf

            {{-- Token enviado pelo e-mail --}}
            <input type="hidden" name="token" value="{{ $token }}">

            <label for="email">E-mail do administrador</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}">

            <label for="senha">Nova senha</label>
            <input type="password" name="senha" id="senha" required>

            <label for="senha_confirmation">Confirmar nova senha</label>
            <input type="password" name="senha_confirmation" id="senha_confirmation" required>

            <button type="submit">Redefinir Senha</button>
        </form>

        <div class="voltar-site" style="margin-top: 15px;">
            <a href="{{ route('admin.login') }}">← Voltar ao login</a>
        </div>

    </div>

</main>
@endsection
