@extends('site.layout')

@section('title', 'Início')

@section('content')

@php
    $config = \App\Models\ConfiguracaoSite::first();
@endphp

{{-- ===============================
      HERO IMAGE (imagem da fachada)
   =============================== --}}
<section class="hero-image">
    <img 
        src="{{ $config && $config->imagem_hero ? asset('storage/' . $config->imagem_hero) : asset('imagens/fachada.png') }}" 
        alt="Fachada da Escola Ana Clara"
    >
</section>

{{-- ===============================
      MISSÃO DA ESCOLA (textos)
   =============================== --}}
<section class="missao-escola">
    <div class="container-texto">

        <h2>
            {{ $config->titulo_missao ?? 'Bem-vindos a um mundo de descobertas e de cuidados.' }}
        </h2>

        <p>
            {{ $config->paragrafo1 ?? 'Aqui, na Escola Ana Clara, unimos o melhor da educação e do cuidado...' }}
        </p>

        <p>
            {{ $config->paragrafo2 ?? 'Nosso foco é o desenvolvimento integral – físico, mental e socioemocional...' }}
        </p>

    </div>
</section>

{{-- ===============================
      RESTANTE DA SUA PÁGINA (NÃO MUDA NADA)
   =============================== --}}
<section class="container-ensino">
    <div class="text-content">
        <h1>CONHEÇA A NOSSA METODOLOGIA</h1>
        <p>E entenda como formamos nossos estudantes.</p>
    </div>

    <div class="cards-container">

        <div class="card card-bercario">
            <img src="{{ asset('imagens/bercario.jpeg') }}" alt="Berçário">
            <a href="{{ route('bercario') }}" class="btn-card">Berçário</a>
        </div>

        <div class="card card-infantil">
            <img src="{{ asset('imagens/educacao_infatil.jpeg') }}" alt="Educação Infantil">
            <a href="{{ route('educacao.infantil') }}" class="btn-card">Educação Infantil</a>
        </div>

        <div class="card card-fundamental-1">
            <img src="{{ asset('imagens/fundamental.jpeg') }}" alt="Ensino Fundamental I">
            <a href="{{ route('ensino.fundamental') }}" class="btn-card">Ensino Fundamental I</a>
        </div>

    </div>
</section>

<section class="section-cartao-creche">
    <div class="image-container">
        <img src="{{ asset('imagens/cartao_creche.png') }}" alt="Cartão Creche" class="cartao-creche-img">
    </div>

    <div class="container-cartao-creche">              
        <div class="text-container">
            <p class="titulo-destaque">E também temos uma ótima notícia para os pais que já possuem o <strong>Cartão Creche!</strong></p>
            <p>Nossa escola é credenciada e aceita o benefício. Traga seu filho para a nossa escola e utilize seu Cartão Creche.</p>
            <p>O Programa Cartão Creche é uma iniciativa do Governo do Distrito Federal que visa expandir o acesso a vagas em creches para crianças de 4 meses a 3 anos e 11 meses. Ele atua em parceria com a Secretaria de Educação do Distrito Federal (SEEDF) para atender as necessidades das famílias e proporcionar um ambiente de aprendizado de qualidade.</p>
            <p><strong>Como conseguir o cartão:</strong></p>
            <p>De acordo com o site da Secretaria de Desenvolvimento Social, para que uma criança possa participar do programa, a inscrição deve ser realizada por meio do serviço <strong>156</strong>. Para mais informações, você pode visitar a página oficial do programa <a href="https://www.sedes.df.gov.br/cartao-creche" target="_blank" rel="noopener noreferrer">Cartão Creche</a>.</p>
        </div>
    </div>
</section>

@endsection
