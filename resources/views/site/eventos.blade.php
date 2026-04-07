@extends('site.layout')

@section('title', 'Eventos')

@section('content')
<main>
    <section class="galeria-eventos">
        <h2>Eventos</h2>

        <div id="eventos-list" class="eventos-container">
            @if($events->isEmpty())
                <div class="sem-eventos">Nenhum evento disponível no momento.</div>
            @else
                @foreach($events as $event)
                    <div class="card-evento-fixo">
                        <div class="card-image-wrapper">
                            <img src="{{ $event->main_image ? asset('storage/' . $event->main_image) : asset('imagens/imagem-padrao.jpg') }}" 
                                 alt="{{ $event->title }}">
                        </div>

                        <div class="card-texto-fixo">
                            <h3>{{ $event->title }}</h3>

                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($event->description), 200) }}</p>

                            <span class="data-evento">
                                {{ $event->event_date ? $event->event_date->format('d/m/Y') : '' }}
                            </span>

                            <button class="btn-galeria" data-event-id="{{ $event->id }}">
                                Ver fotos 
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
</main>

<!-- Modal -->
<div id="modal-galeria" class="modal" style="display:none;">
    <div class="modal-galeria-conteudo">
        <span class="fechar-modal">&times;</span>
        <div class="galeria-modal-container"></div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/eventos.js') }}"></script>
@endsection
