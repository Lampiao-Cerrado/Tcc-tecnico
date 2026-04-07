@extends('site.layout')

@section('title', 'Ensino Fundamental')

@section('content')

<main>
    <h1>ENSINO FUNDAMENTAL</h1>

    <div class="container">

        <div class="banner">
            <img src="{{ asset('imagens/fundamental.jpeg') }}" alt="Banner Ensino Fundamental">
        </div>

        <div class="footer-buttons">
            <a href="#" class="tablink active" data-aba="sobre">SOBRE</a>
            <a href="#" class="tablink" data-aba="horarios">HORÁRIOS</a>
            <a href="#" class="tablink" data-aba="material">MATERIAL ESCOLAR</a>
        </div>

        <div id="sobre" class="tabcontent active">
            <h2>Sobre</h2>
            <p>O Ensino Fundamental da Escola Ana Clara é uma etapa de descobertas e aprendizagens. Valorizamos o desenvolvimento cognitivo, social e emocional de cada estudante, incentivando a autonomia, a criatividade e o gosto pelo aprender.</p>

            <h3>Família e Escola</h3>
            <p>A parceria com a família é essencial. Mantemos um diálogo constante com os responsáveis, fortalecendo a confiança e contribuindo para o sucesso escolar dos nossos estudantes.</p>

            <h3>Rotina e Aprendizagem</h3>
            <p>A rotina é organizada para unir conteúdos, projetos e experiências significativas. As aulas estimulam a leitura, a escrita, a resolução de problemas e o trabalho em grupo, com foco no respeito e na cooperação.</p>

            <div class="bncc-section">
                <h4>Currículo do Ensino Fundamental</h4>
                <p>Nosso trabalho segue a BNCC e contempla:</p>
                <ul>
                    <li><strong>Linguagens:</strong> Português, Arte, Educação Física e Inglês;</li>
                    <li><strong>Matemática;</strong></li>
                    <li><strong>Ciências da Natureza;</strong></li>
                    <li><strong>Ciências Humanas:</strong> História e Geografia.</li>
                </ul>
            </div>
        </div>

        <div id="horarios" class="tabcontent">
            <h2>Horários</h2>
            <p>Período integral: 7h30 às 17h.</p>
            <p>Vespertino: 13h15 às 17h.</p>
        </div>

        <div id="material" class="tabcontent">
            <h2>Material Escolar</h2>
            
            <div class="arquivo">

                @if($lista && is_array($lista->arquivo) && count($lista->arquivo) > 0)

                    <h4>Listas já enviadas:</h4>

                    <ul style="list-style: none; padding-left: 0;">
                        @foreach ($lista->arquivo as $index => $arquivo)
                            <li style="margin-bottom: 8px;">
                                <a
                                    href="{{ asset('storage/' . $arquivo) }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="btn-verde"
                                >
                                    📄 {{ $lista->nomes_exibicao[$index] ?? basename($arquivo) }}
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
    <script src="{{ asset('js/ensino-fundamental.js') }}"></script>
@endsection