@extends('site.layout')

@section('title', 'Pré-matrícula')

@section('content')

<main class="prematricula" style="background-image: url('{{ asset('imagens/fundo_tra.jpg') }}')">

    <div class="formulario-container">
        <div>
            <h2>Pré-matrícula</h2>
        </div>

        <div id="mensagemSucesso" class="mensagem mensagem-sucesso" style="display:none;">
            ✔ Pré-matrícula enviada com sucesso!
        </div>

        <div id="mensagemErro" class="mensagem mensagem-erro" style="display:none;">
            ❌ Erro ao enviar a pré-matrícula.
        </div>


        <div id="carregando" class="carregando">
            ⏳ Enviando...
        </div>

        <form id="formPreMatricula" method="POST" action="{{ route('prematricula.submit') }}">
            @csrf

            <div class="campo-form">
                <label>Nome da criança:</label>
                <input 
                    type="text" 
                    name="nomeCrianca" 
                    value="{{ old('nomeCrianca') }}" 
                    required
                >
            </div>

            <div class="campo-form">
                <label>Data de nascimento:</label>
                <input 
                    type="date" 
                    name="dataNascimento" 
                    value="{{ old('dataNascimento') }}" 
                    required
                >
            </div>

            <div class="campo-form">
                <label>Nome do responsável:</label>
                <input 
                    type="text" 
                    name="nomeResponsavel" 
                    value="{{ old('nomeResponsavel') }}" 
                    required
                >
            </div>

            <div class="campo-form">
                <label>Telefone:</label>
                <input 
                    type="tel" 
                    id="telefone" 
                    name="telefone" 
                    value="{{ old('telefone') }}" 
                    required
                >
            </div>

            <div class="campo-form">
                <label>E-mail:</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                >
            </div>

            <div class="campo-form">
                <label>Turma desejada:</label>
                <select name="turma" required>
                    <option value="">Selecione</option>
                    <option value="bercario II">Berçário II</option>
                    <option value="maternal I">Maternal I</option>
                    <option value="maternal II">Maternal II</option>
                    <option value="jardim I">Jardim I</option>
                    <option value="jardim II">Jardim II</option>
                    <option value="fundamental 1° ano">Ensino Fundamental 1° ano</option>
                    <option value="fundamental 2° ano">Ensino Fundamental 2° ano</option>
                    <option value="fundamental 3° ano">Ensino Fundamental 3° ano</option>
                    <option value="fundamental 4° ano">Ensino Fundamental 4° ano</option>
                    <option value="fundamental 5° ano">Ensino Fundamental 5° ano</option>
                </select>
            </div>

            <div class="campo-form">
                <label>Período:</label>
                <select name="periodo" required>
                    <option value="">Selecione</option>
                    <option value="tarde">Tarde</option>
                    <option value="integral">Integral</option>
                </select>
            </div>

            {{-- CHECKBOX PADRÃO IGUAL AO AGENDAR VISITA --}}
            <div class="termos-aceite">

                <div class="checkbox-container">
                    <input 
                        type="checkbox" 
                        id="aceite_privacidade_prematricula" 
                        name="aceite_privacidade_prematricula" 
                        required
                    >

                    <label class="checkbox-label" for="aceite_privacidade_prematricula">
                        Li e aceito a 
                        <a href="/politica-privacidade">Política de Privacidade</a>
                        e os 
                        <a href="/termos-uso">Termos de Uso</a>
                        <span class="required">*</span>
                    </label>
                </div>

                <p id="termos-error-prematricula" class="error-message">
                    Você deve aceitar os termos para continuar.
                </p>

            </div>

            <button type="submit" class="btn-enviar">Enviar</button>

        </form>
    </div>

</main>

@endsection

@section('scripts')
    <script src="{{ asset('js/prematricula.js') }}"></script>
@endsection
