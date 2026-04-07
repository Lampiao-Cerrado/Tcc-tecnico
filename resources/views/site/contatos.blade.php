@extends('site.layout')

@section('title', 'Contatos')

@section('content')

<main class="gradient-bg-simple">

    <!-- =================== CONTATOS =================== -->
    <section class="contato-wrapper" id="contato">
        <h2 class="contato-titulo">Entre em contato conosco</h2>

        <div class="contato-grid">

            <figure class="contato-imagem">
                <img src="{{ asset('imagens/contato.jpg') }}" 
                     alt="Professora feliz com crianças na sala de aula"
                     loading="lazy">
            </figure>

            <div class="contato-cards">

                <!-- Telefone -->
                <a class="contato-card" 
                   href="tel:+55{{ isset($contato['telefone']) ? preg_replace('/\D/', '', $contato['telefone']) : '' }}">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.02-.24 11.36 11.36 0 003.56.57 1 1 0 011 1v3.61a1 1 0 01-1 1A18.79 18.79 0 013 5a1 1 0 011-1h3.61a1 1 0 011 1 11.36 11.36 0 00.57 3.56 1 1 0 01-.24 1.02l-2.32 2.21z"/>
                        </svg>
                    </span>
                    <div class="textos">
                        <p><strong>Telefone:</strong> {{ $contato['telefone'] ?? 'Não informado' }}</p>
                    </div>
                </a>

                <!-- WhatsApp -->
                <a class="contato-card" 
                   href="https://wa.me/55{{ isset($contato['whatsapp']) ? preg_replace('/\D/', '', $contato['whatsapp']) : '' }}?text=Olá%2C%20gostaria%20de%20mais%20informações"
                   target="_blank">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M20.52 3.48A11.86 11.86 0 0012.01 0 11.95 11.95 0 000 12a11.82 11.82 0 001.64 6l-1.07 3.9 4-1a12 12 0 006.43 1.84h0A11.95 11.95 0 0024 12a11.86 11.86 0 00-3.48-8.52z"/>
                        </svg>
                    </span>
                    <div class="textos">
                        <p><strong>WhatsApp:</strong> {{ $contato['whatsapp'] ?? 'Não informado' }}</p>
                    </div>
                </a>

                <!-- Email -->
                <a class="contato-card" href="mailto:{{ $contato['email'] ?? '' }}">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    </span>
                    <div class="textos">
                        <p><strong>Email:</strong> {{ $contato['email'] ?? 'Não informado' }}</p>
                    </div>
                </a>

            </div>
        </div>
    </section>

    <!-- =================== MAPA =================== -->
    <section class="mapa-localizacao">
        <h2 class="contato-titulo">Nossa Localização</h2>

        <div class="mapa-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3864.7549998075707!2d-48.0288863!3d-16.0241493!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x935980ebed33af95%3A0x95e8f751f105d0bd!2sEscola%20Ana%20Clara%20-%20Unidade%20Santa%20Maria%20Sul!5e0!3m2!1spt-BR!2sbr!4v1732651612345!5m2!1spt-BR!2sbr"
                width="100%"
                height="400"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

</main>

@endsection
