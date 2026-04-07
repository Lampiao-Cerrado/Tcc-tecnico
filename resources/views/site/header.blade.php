<!-- header.blade.php -->
<header>

    <div class="top-bar">
        <a href="{{ route('admin.login') }}">Acesso restrito 🔒</a>
    </div>

    <div class="cabecalho-principal">

        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('imagens/logo_quadro2.png') }}" alt="Logo Escola Ana Clara">
            </a>
        </div>

        <nav class="menu-navegacao">
            <ul>
                <li><a href="{{ url('/') }}">INÍCIO</a></li>

                <li class="menu-item">
                    <a href="#">SOBRE NÓS <span class="seta-baixo"></span></a>
                    <ul class="submenu">
                        <li><a href="{{ url('historia') }}">HISTÓRIA</a></li>
                        <li><a href="{{ url('estrutura') }}">ESTRUTURA</a></li>
                        <li><a href="{{ url('normas') }}">NORMAS DA ESCOLA</a></li>
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="#">TURMAS <span class="seta-baixo"></span></a>
                    <ul class="submenu1">
                        <li><a href="{{ route('bercario') }}">BERÇÁRIO</a></li>
                        <li><a href="{{ route('educacao.infantil') }}">ENSINO INFANTIL</a></li>
                        <li><a href="{{ route('ensino.fundamental') }}">ENSINO FUNDAMENTAL</a></li>
                    </ul>
                </li>

                <li><a href="{{ url('/diferencial') }}">DIFERENCIAL</a></li>
                <li><a href="{{ route('site.eventos') }}">EVENTOS</a></li>
                <li><a href="{{ url('contatos') }}">CONTATOS</a></li>
                <li><a href="{{ route('trabalhe_conosco.form') }}">TRABALHE CONOSCO</a></li>
            </ul>
        </nav>

        <div class="botoes-container">
            <a href="{{ url('agendar-visita') }}" class="btn">Agendar visita</a>
            <a href="{{ route('prematricula.form') }}" class="btn">Pré-matrícula</a>
        </div>

        <button class="menu-hamburguer">&#9776;</button>

    </div>

</header>
