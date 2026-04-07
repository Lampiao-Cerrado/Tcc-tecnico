@extends('site.layout')

@section('title', 'Berçário')

@section('content')

<main>

    <h1>BERÇÁRIO</h1>

    <div class="container">

        <!-- Banner -->
        <div class="banner">
            <img src="{{ asset('/imagens/bercario.jpeg') }}" alt="dois bebês mostrando as mãos sujas de tinta.">
        </div>

        <!-- Abas -->
        <div class="footer-buttons">
            <a href="#" class="tablink active" data-tab="sobre">SOBRE</a>
            <a href="#" class="tablink" data-tab="horarios">HORÁRIOS</a>
            <a href="#" class="tablink" data-tab="material">MATERIAL ESCOLAR</a>
        </div>

        <!-- Conteúdo das Abas -->
        <div id="sobre" class="tabcontent active">
            <h2>Sobre</h2>
            <p>
                O berçário da <strong>Escola Ana Clara</strong> é um espaço acolhedor, pensado com carinho para os primeiros anos de vida da criança.
            </p>

            <h3>Família e Escola</h3>
            <p>
                Acreditamos que a parceria entre escola e família é fundamental.
            </p>

            <h3>Rotina e Aprendizagem</h3>
            <p>
                Nossos pequenos vivenciam experiências que estimulam a curiosidade e o encantamento pelo mundo.
            </p>
        </div>

        <div id="horarios" class="tabcontent">
            <h2>Horários</h2>
            <p>Período integral: 7h30 às 16h45</p>
            <p>Vespertino: 13h00 às 16h45</p>
        </div>

        <div id="material" class="tabcontent">
            <h2>Material Escolar</h2>

            <div class="arquivo">

                @if($lista && is_array($lista->arquivo) && count($lista->arquivo) > 0)

                    <p><strong>Listas de Materiais:</strong></p>

                    @foreach($lista->arquivo as $pdf)
                        <div class="arquivo-item">
                            <a
                                href="{{ asset('storage/' . $pdf) }}"
                                target="_blank"
                                rel="noopener"
                                class="btn-verde"
                            >
                                📄 Abrir {{ $lista->nomes_exibicao[$loop->index] ?? basename($pdf) }}

                            </a>
                        </div>
                    @endforeach

                @else
                    <p>Nenhum material escolar enviado ainda.</p>
                @endif

            </div>


        </div>

    </div>

</main>

@endsection

@section('scripts')
<script src="{{ asset('js/tabs.js') }}"></script>
@endsection
