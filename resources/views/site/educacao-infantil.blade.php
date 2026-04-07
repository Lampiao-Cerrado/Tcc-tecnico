@extends('site.layout')

@section('title', 'Educação Infantil')

@section('content')

<main>
    <h1>EDUCAÇÃO INFANTIL</h1>

    <div class="container">

        <div class="banner">
            <img src="{{ asset('/imagens/educacao_infatil.jpeg') }}" alt="Banner Educação Infantil">
        </div>

        <div class="footer-buttons">
            <a href="#" class="tablink active" data-aba="sobre">SOBRE</a>
            <a href="#" class="tablink" data-aba="horarios">HORÁRIOS</a>
            <a href="#" class="tablink" data-aba="material">MATERIAL ESCOLAR</a>
        </div>

        <div id="sobre" class="tabcontent active">
            <h2>Sobre</h2>
            <p>
                A Educação Infantil da Escola Ana Clara é um espaço de descobertas, afetividade e aprendizado...
            </p>

            <h3>Família e Escola</h3>
            <p>
                Acreditamos que família e escola caminham juntas na formação da criança...
            </p>

            <h3>Rotina e Aprendizagem</h3>
            <p>
                A rotina é organizada para unir cuidado, brincadeira e aprendizado...
            </p>

            <div class="bncc-section">
                <h4>Currículo da Educação Infantil</h4>
                <p>
                    Nossa proposta pedagógica segue a BNCC...
                </p>
                <ul>
                    <li><strong>O eu, o outro e o nós:</strong> ...</li>
                    <li><strong>Corpo, gestos e movimentos:</strong> ...</li>
                    <li><strong>Traços, sons, cores e formas:</strong> ...</li>
                    <li><strong>Escuta, fala, pensamento e imaginação:</strong> ...</li>
                    <li><strong>Espaços, tempos, quantidades, relações e transformações:</strong> ...</li>
                </ul>
            </div>
        </div>

        <div id="horarios" class="tabcontent">
            <h2>Horários</h2>
            <p>Período integral: 7h30 às 16h45</p>
            <p>Vespertino: 13h00 às 16h45</p>
        </div>

        <div id="material" class="tabcontent">
            <h2>Material Escolar</h2>

            <div class="arquivo">
                @if ($lista && is_array($lista->arquivo) && count($lista->arquivo) > 0)

                    <h4>Listas de materiais disponíveis:</h4>

                    <ul class="lista-materiais">
                        @foreach ($lista->arquivo as $index => $arquivo)
                            <li>
                                <a href="{{ asset('storage/' . $arquivo) }}" 
                                target="_blank"
                                class="btn-verde">

                                    📄 {{ $lista->nomes_exibicao[$index] ?? 'Abrir arquivo' }}

                                </a>
                            </li>
                        @endforeach
                    </ul>

                @else
                    <p>Nenhum material escolar enviado ainda.</p>
                @endif
            </div>


        </div>

    </div>
</main>

@endsection

@section('scripts')
    <script src="{{ asset('js/educacao-infantil.js') }}"></script>
@endsection
