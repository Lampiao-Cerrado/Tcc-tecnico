@extends('site.layout')

@section('title', 'Estrutura - Escola Ana Clara')

@section('content')

<main>

    <section class="estrutura-intro">
        <h1>Nossa Estrutura</h1>
        <p>
            Conhecer a nossa infraestrutura é a melhor forma de entender o cuidado e a qualidade que oferecemos.
            Na <strong>Escola Ana Clara</strong>, cada espaço foi pensado para o desenvolvimento integral de nossos alunos...
        </p>
    </section>

    <!-- Brinquedoteca -->
    <section class="estrutura-secao_brinquedoteca">
        <h2>Brinquedoteca</h2>
        <p>
            Nossa Brinquedoteca é um universo de descobertas! Aqui, a aprendizagem acontece de forma lúdica e espontânea...
        </p>

        <div class="galeria">
            <img src="{{ asset('imagens/estrutura/brinquedoteca.jpeg') }}" alt="Brinquedoteca 1">
            <img src="{{ asset('imagens/estrutura/brinquedoteca1.jpeg') }}" alt="Brinquedoteca 2">
            <img src="{{ asset('imagens/estrutura/brinquedoteca2.jpeg') }}" alt="Brinquedoteca 3">
            <img src="{{ asset('imagens/estrutura/brinquedoteca3.jpeg') }}" alt="Brinquedoteca 4">
            <img src="{{ asset('imagens/estrutura/brinquedoteca4.jpeg') }}" alt="Brinquedoteca 5">
            <img src="{{ asset('imagens/estrutura/brinquedoteca5.jpeg') }}" alt="Brinquedoteca 6">
            <img src="{{ asset('imagens/estrutura/brinquedoteca6.jpeg') }}" alt="Brinquedoteca 7">
            <img src="{{ asset('imagens/estrutura/brinquedoteca7.jpeg') }}" alt="Brinquedoteca 8">
        </div>
    </section>

    <!-- Biblioteca -->
    <section class="estrutura-secao">
        <h2>Biblioteca</h2>
        <p>
            Nossa Biblioteca é o portal para a aventura e o conhecimento...
        </p>
        <div class="galeria">
            <img src="{{ asset('imagens/estrutura/biblioteca.jpeg') }}" alt="Biblioteca 1">
        </div>
    </section>

    <!-- Quadra -->
    <section class="estrutura-secao">
        <h2>Quadra Poliesportiva</h2>
        <p>
            Na nossa Quadra Poliesportiva, a energia é contagiante! ...
        </p>

        <div class="galeria">
            <img src="{{ asset('imagens/estrutura/quadra.jpeg') }}" alt="Quadra 1">
            <img src="{{ asset('imagens/estrutura/quadra1.jpeg') }}" alt="Quadra 2">
        </div>
    </section>

    <!-- Energia Solar -->
    <section class="estrutura-secao">
        <h2>Energia Fotovoltaica</h2>
        <p>
            Mais do que uma escola, somos um exemplo de sustentabilidade...
        </p>

        <div class="galeria">
            <img src="{{ asset('imagens/estrutura/placaSolar.jpeg') }}" alt="Energia Solar 1">
            <img src="{{ asset('imagens/estrutura/placaSolar1.jpeg') }}" alt="Energia Solar 2">
        </div>
    </section>

    <!-- Primeiros Socorros -->
    <section class="estrutura-secao">
        <h2>Treinamento de Primeiros Socorros</h2>
        <p>
            A segurança de seus filhos é nossa prioridade máxima...
        </p>

        <div class="galeria">
            <img src="{{ asset('imagens/estrutura/cursoBomb.jpeg') }}" alt="Curso Bombeiros 1">
            <img src="{{ asset('imagens/estrutura/cursoBomb1.jpeg') }}" alt="Curso Bombeiros 2">
        </div>
    </section>

</main>

<!-- Modal -->
<div id="modal" class="modal">
    <span class="fechar">&times;</span>
    <div class="modal-conteudo-wrapper">
        <img class="modal-conteudo" id="imgAmpliada">
        <div id="caption"></div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/estrutura.js') }}"></script>
@endsection
