@extends('site.layout')

@section('title', 'Trabalhe conosco')

@section('content')
<main>
    <section class="trabalhe-conosco-form">
        <div class="container-form">
            <h2>Envie seu Currículo</h2>

            <div id="mensagemSucesso" 
                class="mensagem mensagem-sucesso {{ session('success') ? 'msg-visible' : 'msg-hidden' }}">
                ✔ {{ session('success') }}
            </div>

            <div id="mensagemErro" 
                class="mensagem mensagem-erro {{ $errors->any() ? 'msg-visible' : 'msg-hidden' }}">
                ❌ Ocorreu um erro ao enviar o currículo.

                @if($errors->any())
                    <ul style="margin-top:10px;">
                        @foreach($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>


            <form id="curriculoForm" action="{{ route('trabalhe_conosco.submit') }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" value="{{ old('telefone') }}" required>
                </div>

                <div class="form-group">
                    <label for="area">Área de Interesse</label>
                    <select id="area" name="area" required>
                        <option value="">Selecione</option>
                        <option value="Professor" {{ old('area')=='Professor'?'selected':'' }}>Professor</option>
                        <option value="Monitor" {{ old('area')=='Monitor'?'selected':'' }}>Monitor</option>
                        <option value="Administrativo" {{ old('area')=='Administrativo'?'selected':'' }}>Administrativo</option>
                        <option value="Outro" {{ old('area')=='Outro'?'selected':'' }}>Outro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="curriculo">Anexar Currículo (PDF, até 5MB)</label>
                    <input type="file" id="curriculo" name="curriculo" 
                           accept="application/pdf" required>
                </div>

                <div class="form-group">
                    <label for="mensagem">Mensagem (opcional)</label>
                    <textarea id="mensagem" name="mensagem" rows="4">{{ old('mensagem') }}</textarea>
                </div>

                <div class="checkbox-container">
                    <input type="checkbox" id="aceite_privacidade" name="aceite_privacidade" required>

                    <label class="checkbox-label" for="aceite_privacidade">
                        Li e aceito a 
                        <a href="/politica-privacidade">Política de Privacidade</a>
                        e os 
                        <a href="/termos-uso">Termos de Uso</a>
                        <span class="required">*</span>
                    </label>
                </div>

                <p id="termoErro" style="display:none; color:red; font-size:14px; margin-top:5px;">
                    Você deve aceitar os termos para continuar.
                </p>

                <button type="submit" class="btn">📤 Enviar Currículo</button>
            </form>
        </div>
    </section>
</main>
@endsection

@section('scripts')
    <script src="{{ asset('js/trabalhe_conosco.js') }}"></script>
@endsection
