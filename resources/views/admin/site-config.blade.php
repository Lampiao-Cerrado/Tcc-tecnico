@extends('admin.layout') {{-- ou site.layout se for o caso --}}

@section('content')
<div class="card">
  <h2>Configurações do Site</h2>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form action="{{ route('admin.site.salvar') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label>Título da Missão</label>
      <input type="text" name="titulo_missao" value="{{ old('titulo_missao', $config->titulo_missao ?? '') }}" class="form-control">
    </div>

    <div class="form-group">
      <label>Parágrafo 1</label>
      <textarea name="paragrafo1" class="form-control" rows="4">{{ old('paragrafo1', $config->paragrafo1 ?? '') }}</textarea>
    </div>

    <div class="form-group">
      <label>Parágrafo 2</label>
      <textarea name="paragrafo2" class="form-control" rows="4">{{ old('paragrafo2', $config->paragrafo2 ?? '') }}</textarea>
    </div>

    <div class="form-group">
      <label>Imagem Hero</label>
      @if(!empty($config->imagem_hero))
        <div style="margin-bottom:8px;">
          <img src="{{ asset('storage/' . $config->imagem_hero) }}" alt="Imagem hero" style="max-width:300px; height:auto; border:1px solid #ddd;">
        </div>
      @endif
      <input type="file" name="imagem_hero" accept="image/*">
      <small class="form-text text-muted">Tamanho recomendado: ...</small>
    </div>

    <button class="btn btn-primary" type="submit">Salvar</button>
  </form>
</div>
@endsection
