@extends('site.layout')

@section('title', 'Diferencial')

@section('content')

<main>

    <div class="teste">
        <h1>Nosso Diferencial</h1>
        <h3><br>
            Na nossa escola, acreditamos que a educação deve ir além do ensino tradicional, promovendo experiências que estimulam tanto o aprendizado quanto o desenvolvimento integral das crianças.
        </br></h3>

        <p><br>
            Oferecemos atividades que unem disciplina, criatividade, movimento e bem-estar:
        </br></p>
    </div>

    <section class="container-diferenciais">

        <div class="card_diferencial">
            <img src="{{ asset('imagens/diferencial/bale.jpeg') }}" alt="Aula de Balé">
            <h3>Aula de Balé</h3>
            <p>Atividades de balé que estimulam a disciplina, a postura, a coordenação motora e a expressão corporal das crianças.</p>
        </div>

        <div class="card_diferencial">
            <img src="{{ asset('imagens/diferencial/musica.jpeg') }}" alt="Aula de Musicalização">
            <h3>Aula de Musicalização</h3>
            <p>Desenvolvimento da percepção musical e da sensibilidade através de atividades com sons e ritmos.</p>
        </div>

        <div class="card_diferencial">
            <img src="{{ asset('imagens/diferencial/karate.jpeg') }}" alt="Karatê">
            <h3>Karatê</h3>
            <p>Aulas de karatê que incentivam o respeito, a disciplina e a autoconfiança das crianças.</p>
        </div>

        <div class="card_diferencial">
            <img src="{{ asset('imagens/diferencial/piscico.jpeg') }}" alt="Psicomotricidade">
            <h3>Psicomotricidade</h3>
            <p>Exercícios que estimulam o equilíbrio, a coordenação e a consciência corporal dos alunos.</p>
        </div>

        <div class="card_diferencial">
            <img src="{{ asset('imagens/diferencial/esporte.jpeg') }}" alt="Esportes">
            <h3>Esportes</h3>
            <p>Práticas esportivas variadas que desenvolvem o espírito de equipe e hábitos saudáveis.</p>
        </div>

        <div class="card_diferencial">
            <img src="{{ asset('imagens/diferencial/cognitivo.jpeg') }}" alt="Desenvolvimento Cognitivo e Motor">
            <h3>Desenvolvimento Cognitivo e Motor</h3>
            <p>Atividades pedagógicas estimulando o raciocínio, memória e habilidades motoras das crianças.</p>
        </div>

    </section>

</main>

@endsection
