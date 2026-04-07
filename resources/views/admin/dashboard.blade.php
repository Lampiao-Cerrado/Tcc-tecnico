@extends('admin.layout')

@section('title', 'Painel Administrativo')

@section('content')

<aside class="sidebar">
    <h2>Painel Administrador</h2>

    <ul>
        <li><a href="#" class="nav-link active" data-target="home">Início</a></li>
        <li><a href="#" class="nav-link" data-target="materiais">Listas de Materiais</a></li>
        <li><a href="#" class="nav-link" data-target="eventos">Eventos</a></li>
        <li><a href="#" class="nav-link" data-target="contato">Contato</a></li>
        <li><a href="#" class="nav-link" data-target="formularios">Formulários</a></li>

        <li>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    Sair
                </button>
            </form>
        </li>

    </ul>
</aside>


<main class="content">

    <div id="notificacao-sucesso" 
        class="notificacao-sucesso"
        data-show="{{ session('status') ? '1' : '0' }}">
        Alteração realizada com sucesso!
    </div>




    {{-- BUSCA DA CONFIG GARANTIDA --}}
    @php
        $config = \App\Models\ConfiguracaoSite::first();
    @endphp


    {{-- SEÇÃO HOME --}}
    <section id="home" class="section active">

        <h3>Gerenciar Seção Inicio da Escola</h3>

        <form action="{{ route('admin.site.salvar') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Título:</label>
                <input type="text" name="titulo_missao"
                       value="{{ $config?->titulo_missao ?? '' }}">
            </div>

            <div class="form-group">
                <label>Parágrafo 1:</label>
                <textarea name="paragrafo1" rows="5">{{ $config?->paragrafo1 ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label>Parágrafo 2:</label>
                <textarea name="paragrafo2" rows="5">{{ $config?->paragrafo2 ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label>Imagem Atual:</label><br>

                @php
                    $imagem = $config && $config->imagem_hero
                        ? asset('storage/'.$config->imagem_hero)
                        : asset('imagens/fachada.png');
                @endphp

                <img src="{{ $imagem }}" style="max-width:250px;border-radius:6px;border:1px solid #ccc;">
            </div>

            <div class="form-group">
                <label>Alterar Imagem:</label>
                <input type="file" name="imagem_hero">
            </div>

            <div class="form-group">
                <button type="submit">Atualizar</button>
            </div>

        </form>
    </section>

    {{-- SEÇÃO LISTA DE MATERIAIS --}}
        <section id="materiais" class="section">
        <h3>Gerenciar Listas de Materiais</h3>

        @php
            $bercario = \App\Models\ListaMaterial::where('turma', 'bercario')->first();
            $infantil = \App\Models\ListaMaterial::where('turma', 'infantil')->first();
            $fundamental = \App\Models\ListaMaterial::where('turma', 'fundamental')->first();
        @endphp

        @foreach ([
            'bercario' => $bercario,
            'infantil' => $infantil,
            'fundamental' => $fundamental
        ] as $turma => $registro)

            <h4>{{ ucfirst($turma) }}</h4>

            @if($registro && is_array($registro->arquivo))
                <p><strong>Arquivos enviados:</strong></p>

                <form action="{{ route('admin.lista_materiais.editarNomes') }}" 
                    method="POST" 
                    class="mb-3 lista-form">

                    @csrf
                    <input type="hidden" name="turma" value="{{ $turma }}">

                    <ul style="list-style: none; padding-left: 0;">
                        @foreach($registro->arquivo as $index => $pdf)
                            <li style="margin-bottom: 12px; display:flex; align-items:center; gap:10px;">

                                <strong>Nome exibido:</strong>

                                <input 
                                    type="text"
                                    name="nomes_exibicao[{{ $index }}]"
                                    value="{{ $registro->nomes_exibicao[$index] ?? basename($pdf) }}"
                                    style="padding:4px; width:260px;"
                                >

                                <a href="{{ asset('storage/'.$pdf) }}" target="_blank">
                                    📄 Abrir arquivo
                                </a>

                                {{-- BOTÃO EXCLUIR --}}
                                <button 
                                    type="button"
                                    class="btn-remover"
                                    data-turma="{{ $turma }}"
                                    data-arquivo="{{ $pdf }}"
                                    style="color:red; background:none; border:none; cursor:pointer;"
                                >
                                    ❌ Excluir
                                </button>

                                {{-- BOTÃO SALVAR ESTE NOME (VERDE) --}}
                                <button 
                                    type="submit"
                                    name="salvar_individual"
                                    value="{{ $index }}"
                                    class="btn-verde"
                                >
                                    Salvar Nome
                                </button>

                            </li>
                        @endforeach
                    </ul>

                </form>

            @else
                <p>Nenhum arquivo enviado ainda.</p>
            @endif

            {{-- FORM PARA ENVIAR NOVOS ARQUIVOS --}}
            <form action="{{ route('admin.lista_materiais.salvar') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf
                <input type="hidden" name="turma" value="{{ $turma }}">
                <label><strong>Enviar novos PDFs:</strong></label><br>

                <input type="file" name="arquivo[]" accept="application/pdf" multiple>

                <button type="submit" class="btn-verde mt-2">Enviar Arquivos</button>
            </form>

            <hr>

        @endforeach

        {{-- FORM OCULTO PARA EXCLUSÃO --}}
        <form id="form-remover" action="{{ route('admin.lista_materiais.remover') }}" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="turma" id="remover-turma">
            <input type="hidden" name="arquivo" id="remover-arquivo">
        </form>

    </section>



   {{-- SEÇÃO EVENTOS --}}
    <section id="eventos" class="section">

        <h3>Gerenciar Eventos</h3>

        <button id="btn-add-evento" class="btn-adicionar">+ Adicionar Novo Evento</button>

        <div id="form-evento" class="form-evento" style="display:none;">
            <h4 id="titulo-form-evento">Adicionar Novo Evento</h4>

            <form id="form-evento-data" enctype="multipart/form-data">

                <input type="hidden" id="evento-id" name="id" value="">

                <div class="form-group">
                    <label>Título do Evento:</label>
                    <input type="text" id="evento-titulo" name="title" required>
                </div>

                <div class="form-group">
                    <label>Descrição:</label>
                    <textarea id="evento-descricao" name="description" required></textarea>
                </div>

                <div class="form-group">
                    <label>Data do Evento:</label>
                    <input type="date" id="evento-data" name="event_date" required>
                </div>

                <div class="form-group">
                    <label>Imagem Principal:</label>
                    <input type="file" id="evento-imagem" name="main_image" accept="image/*">

                </div>

                <div class="form-group">
                    <label>Imagens Extras:</label>
                    <input type="file" id="evento-galeria" name="gallery[]" multiple accept="image/*">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-editar">Salvar Evento</button>
                    <button type="button" id="btn-fechar-form" class="btn-excluir">Cancelar</button>
                </div>

            </form>
        </div>

        <div id="lista-eventos" class="eventos-container"></div>

    </section>







    {{-- SEÇÃO CONTATO --}}
    <section id="contato" class="section">

        @php
            $contato = \App\Models\Contato::first();
        @endphp

        <h3>Gerenciar Contatos</h3>

        <form action="{{ route('admin.contatos.salvar') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Telefone:</label>
                <input type="text" name="telefone" placeholder="(61) 99999-9999"
                    value="{{ $contato->telefone ?? '' }}">
            </div>

            <div class="form-group">
                <label>WhatsApp:</label>
                <input type="text" name="whatsapp" placeholder="(61) 99999-9999"
                    value="{{ $contato->whatsapp ?? '' }}">
            </div>

            <div class="form-group">
                <label>E-mail:</label>
                <input type="email" name="email" placeholder="contato@escolaanaclara.com"
                    value="{{ $contato->email ?? '' }}">
            </div>

            <div class="form-group">
                <button type="submit">Atualizar Contatos</button>
            </div>

        </form>

    </section>




    {{-- SEÇÃO FORMULÁRIOS --}}
    <section id="formularios" class="section">
        <h3>Gerenciar Formulários Recebidos</h3>

        <div class="abas-formularios">
            <div class="aba ativa" data-aba="curriculos">Currículos</div>
            <div class="aba" data-aba="prematriculas">Pré-matrículas</div>
            <div class="aba" data-aba="agendamentos">Agendamentos de Visita</div>
        </div>

        {{-- Currículos --}}
        <div id="curriculos" class="conteudo-aba ativa">
            <h4>Currículos Recebidos</h4>

            <div class="tabela-container">
                <table id="tabela-curriculos">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Cargo desejado</th>
                            <th>Mensagem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Preenchido via JS -->
                    </tbody>
                </table>
            </div>

            <div id="sem-curriculos" class="sem-registros" style="display: none;">
                Nenhum currículo recebido até o momento.
            </div>
        </div>

        {{-- Pré-matrículas --}}
        <div id="prematriculas" class="conteudo-aba">
            <h4>Pré-matrículas Recebidas</h4>

            <div class="tabela-container">
                <table id="tabela-prematriculas">
                    <thead>
                        <tr>
                            <th>Responsável</th>
                            <th>Nome da criança</th>
                            <th>Idade</th>
                            <th>Turma</th>
                            <th>Período</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Preenchido via JS -->
                    </tbody>
                </table>
            </div>

            <div id="sem-prematriculas" class="sem-registros" style="display: none;">
                Nenhuma pré-matrícula recebida até o momento.
            </div>
        </div>

        {{-- Agendamentos --}}
        <div id="agendamentos" class="conteudo-aba">
            <h4>Agendamentos de Visita</h4>

            <div class="tabela-container">
                <table id="tabela-agendamentos">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Data visita</th>
                            <th>Horário</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Preenchido via JS -->
                    </tbody>
                </table>
            </div>

            <div id="sem-agendamentos" class="sem-registros" style="display: none;">
                Nenhum agendamento recebido até o momento.
            </div>
        </div>
    </section>

    {{-- Modal --}}
    <div id="modal-detalhes" class="modal">
        <div class="modal-conteudo">
            <span class="fechar">&times;</span>
            <div id="conteudo-modal"></div>
        </div>
    </div>


</main>

@endsection

@section('scripts')
<script src="{{ asset('js/admin-formularios.js') }}"></script>
<script src="{{ asset('js/admin-eventos.js') }}"></script>
<script src="{{ asset('js/listaMateriais.js') }}" defer></script>

@endsection