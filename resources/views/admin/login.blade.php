@extends('site.layout')

@section('title', 'Login Administrador')

@section('content')
<main class="loginTeste">

    <div class="login-container">
        <h1>Login Administrador</h1>

        @if($errors->any())
            <div class="alert-login-error">
                <span class="alert-icon">⚠</span>
                {{ $errors->first('login') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.autenticar') }}">

            @csrf

            <label for="usuario">Usuário ou E-mail</label>
            <input type="text" name="usuario" id="usuario" value="{{ old('usuario') }}" required>

            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" required>

            <button type="submit">Entrar</button>
            
            <div class="recuperar">
                <a href="{{ route('admin.esqueci') }}">Esqueceu a senha?</a>
            </div>
            
        </form>

        <div class="voltar-site">
            <a href="{{ url('/') }}">← Voltar ao site</a>
        </div>
    </div>

</main>
@endsection
