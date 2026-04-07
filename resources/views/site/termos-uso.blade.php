@extends('site.layout')

@section('title', 'Termos de Uso')

@section('content')
<main class="tu-page">
    <div class="tu-container">

        <header class="tu-header">
            <h1>Termos de Uso</h1>
            <p class="tu-subtitle">Escola Ana Clara</p>
        </header>

        <section class="tu-section">
            <h2>1. Aceitação dos Termos</h2>
            <p>Ao acessar e usar o site da Escola Ana Clara, você concorda com estes Termos de Uso e com nossa Política de Privacidade. Se não concordar, por favor, não use o site.</p>
        </section>

        <section class="tu-section">
            <h2>2. Uso do Site</h2>

            <h3>2.1. Permissões</h3>
            <ul>
                <li>Navegar e visualizar conteúdo</li>
                <li>Usar formulários para contato</li>
                <li>Agendar visitas</li>
                <li>Enviar currículos</li>
                <li>Preencher pré-matrículas</li>
            </ul>

            <h3>2.2. Proibições</h3>
            <ul>
                <li>Usar o site para atividades ilegais</li>
                <li>Tentar acessar áreas restritas</li>
                <li>Enviar conteúdo malicioso</li>
                <li>Copiar conteúdo sem permissão</li>
                <li>Realizar ataques contra o site</li>
            </ul>
        </section>

        <section class="tu-section">
            <h2>3. Formulários e Interações</h2>

            <h3>3.1. Trabalhe Conosco</h3>
            <ul>
                <li>Currículos em PDF</li>
                <li>Informações reais</li>
                <li>Armazenamento por até 3 anos</li>
            </ul>

            <h3>3.2. Pré-matrícula</h3>
            <ul>
                <li>Não garante vaga</li>
                <li>Usado apenas para contato</li>
                <li>Responsável deve ter mais de 18 anos</li>
            </ul>

            <h3>3.3. Agendamento de Visitas</h3>
            <ul>
                <li>Sujeito à disponibilidade</li>
                <li>Confirmado via e-mail ou telefone</li>
                <li>Cancelamento com 24h de antecedência</li>
            </ul>
        </section>

        <section class="tu-section">
            <h2>4. Propriedade Intelectual</h2>
            <p>Todo o conteúdo deste site pertence à Escola Ana Clara.</p>

            <div class="tu-warning">
                ⚠️ <strong>A reprodução não autorizada é proibida.</strong>
            </div>
        </section>

        <section class="tu-section">
            <h2>5. Links para Terceiros</h2>
            <p>Não nos responsabilizamos por sites externos acessados através de links.</p>
        </section>

        <section class="tu-section">
            <h2>6. Limitação de Responsabilidade</h2>
            <p>A Escola Ana Clara não se responsabiliza por:</p>
            <ul>
                <li>Interrupções temporárias do site</li>
                <li>Erros de conteúdo</li>
                <li>Força maior</li>
                <li>Uso indevido por terceiros</li>
            </ul>
        </section>

        <section class="tu-section">
            <h2>7. Privacidade</h2>
            <p>O uso de dados segue nossa 
                <a href="{{ url('politica-privacidade') }}">Política de Privacidade</a>.
            </p>
        </section>

        <section class="tu-section">
            <h2>8. Modificações</h2>
            <p>Os Termos podem ser alterados a qualquer momento.</p>
        </section>

        <section class="tu-section">
            <h2>9. Lei Aplicável</h2>
            <p>Regido pelas leis brasileiras, foro de Brasília/DF.</p>
        </section>

        <section class="tu-section">
            <h2>10. Contato</h2>
            <ul>
                <li><strong>E-mail:</strong> contato@escolaana.com.br</li>
                <li><strong>Telefone:</strong> (61) 3939-4173</li>
                <li><strong>Endereço:</strong> Qr 208 Conjunto A Lotes 11/12/13 e 34/35, Brasília - DF</li>
            </ul>
        </section>

        <div class="tu-footer">
            <a href="{{ url('/') }}" class="tu-back-btn">← Voltar ao Site Principal</a>
            <p>© 2025 Escola Ana Clara. Todos os direitos reservados.</p>
        </div>

    </div>
</main>
@endsection
