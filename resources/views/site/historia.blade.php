@extends('site.layout')

@section('title', 'História')

@section('content')

<section class="historia-escola">
    <div class="container-historia">
        <h1>A História da Nossa Escola</h1>

        <div class="imagem-historia">
            <img src="{{ asset('imagens/historia1.png') }}" alt="Imagem da História">
        </div>

        <div class="texto-historia">
            <p>A Escola Ana Clara, que começou a funcionar em 2006, é a realização de um antigo sonho: um espaço no qual a educação fosse além da sala de aula. Assim, ela foi fundada pela necessidade de educar e de conscientizar os cidadãos, proporcionando um ambiente no qual os alunos possam construir seu próprio conhecimento.</p>

            <p>A criação da escola também veio para atender a uma necessidade real da comunidade de Santa Maria: a falta de vagas nas escolas públicas da região. Vendo essa demanda, a Escola Ana Clara oferece Educação Infantil (para crianças de 2 a 5 anos) e Ensino Fundamental I (1º ao 5º ano). O objetivo é permitir que as crianças deem continuidade á sua jornada educacional na mesma instituição, garantindo uma transição progressiva e um desenvolvimento integral — físico, psicológico, intelectual, social ético. Além do compromisso com a excelência educacional e o desenvolvimento de seus alunos, a Escola Ana Clara também está alinhada com importantes iniciativas sociais e ambientais.</p>

            <p>Vale a pena ressaltar que desde abril de 2021, a escola passou a aceitar o Cartão Creche, uma medida que amplia o acesso à educação de qualidade para um número maior de famílias da comunidade, visando expandir o acesso a vagas em creches para crianças de 4 meses a 3 anos e 11 meses.</p>

            <p>Com uma visão de futuro e preocupação com o meio ambiente, a Escola Ana Clara vai além e adota práticas sustentáveis. Para demonstrar seu compromisso com a natureza e com a educação ambiental, a escola já utiliza energia solar, reforçando sua missão de construir um futuro mais consciente e responsável para as próximas gerações. A escola é mantida por uma família que abraçou a missão de educar e cuidar, com muita dedicação e amor. A visão deles é transformar a Escola Ana Clara em uma grande família, unindo a comunidade e a escola em uma parceria de responsabilidades e participação.</p>
        </div>
    </div>
</section>

@endsection
