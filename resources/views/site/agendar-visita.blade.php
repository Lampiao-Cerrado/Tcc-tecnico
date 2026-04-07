@extends('site.layout')

@section('title', 'Agendar Visita')

@section('content')

<main class="prematricula" style="background-image: url('{{ asset('imagens/fundo_tra.jpg') }}')">

    <div class="formulario-container">
        <div>
            <h2>Agendar Visita</h2>
        </div>

        <!-- Mensagens padronizadas -->
        <div id="mensagemSucesso"
            class="mensagem mensagem-sucesso {{ session('success') ? 'msg-visible' : 'msg-hidden' }}">
            ✔ {{ session('success') }}
        </div>

        <div id="mensagemErro"
            class="mensagem mensagem-erro {{ $errors->any() ? 'msg-visible' : 'msg-hidden' }}">
            ❌ Erro no envio. Verifique os dados.
        </div>


        <!-- Loading -->
        <div id="carregando" class="carregando msg-hidden">
            ⏳ Enviando...
        </div>

        <form id="formAgendarVisita" method="POST" action="{{ route('agendar.submit') }}">
            @csrf

            <div class="campo-form">
                <label>Nome:</label>
                <input type="text" name="nome" value="{{ old('nome') }}" required>
            </div>

            <div class="campo-form">
                <label>E-mail:</label>
                <input type="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="campo-form">
                <label>Telefone:</label>
                <input type="tel" id="telefone" name="telefone" value="{{ old('telefone') }}" required>
            </div>

            <div class="campo-form">
                <label>Data da visita:</label>
                <input type="date" name="data_visita" value="{{ old('data_visita') }}" required>
            </div>

            <div class="campo-form">
                <label>Hora:</label>
                <input type="time" name="hora" value="{{ old('hora') }}" min="07:00" max="17:00" required>
            </div>

            <div class="campo-form">
                <label>Mensagem:</label>
                <textarea name="mensagem">{{ old('mensagem') }}</textarea>
            </div>

            <div class="termos-aceite">

                <div class="checkbox-container">
                    <input 
                        type="checkbox" 
                        id="aceite_privacidade_agendamento" 
                        name="aceite_privacidade_agendamento" 
                        required
                    >

                    <label class="checkbox-label" for="aceite_privacidade_agendamento">
                        Li e aceito a 
                        <a href="/politica-privacidade">Política de Privacidade</a>
                        e os 
                        <a href="/termos-uso">Termos de Uso</a>
                        <span class="required">*</span>
                    </label>
                </div>

                <p id="termos-error-agendamento" class="error-message">
                    Você deve aceitar os termos para continuar.
                </p>

            </div>


            <button type="submit" class="btn-enviar">Enviar</button>
        </form>
    </div>

</main>

@endsection

@section('scripts')
    <script src="{{ asset('js/agendar-visita.js') }}"></script>
@endsection
