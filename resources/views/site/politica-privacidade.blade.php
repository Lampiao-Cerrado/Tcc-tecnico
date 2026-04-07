@extends('site.layout')

@section('title', 'Política de Privacidade')

@section('content')
<main class="pp-page">
  <div class="pp-container">

    <header class="pp-header">
      <h1>Política de Privacidade</h1>
      <div class="pp-subtitle">Escola Ana Clara</div>
    </header>

    <section class="pp-section">
      <h2>1. Introdução</h2>
      <p>A Escola Ana Clara valoriza a privacidade e a proteção de dados de seus alunos, responsáveis, colaboradores e visitantes. Esta política explica como coletamos, usamos, armazenamos e protegemos suas informações pessoais, em conformidade com a Lei Geral de Proteção de Dados (LGPD - Lei 13.709/2018).</p>
    </section>

    <section class="pp-section">
      <h2>2. Dados que Coletamos</h2>

      <h3>2.1. Dados Pessoais</h3>
      <ul>
        <li><strong>Nome completo</strong></li>
        <li><strong>E-mail</strong></li>
        <li><strong>Telefone</strong></li>
        <li><strong>Endereço</strong></li>
        <li><strong>Data de nascimento</strong></li>
      </ul>

      <h3>2.2. Dados de Crianças e Adolescentes</h3>
      <ul>
        <li>Nome da criança</li>
        <li>Data de nascimento</li>
        <li>Informações médicas relevantes</li>
        <li>Fotos e trabalhos escolares (com autorização)</li>
      </ul>

      <h3>2.3. Dados Profissionais</h3>
      <ul>
        <li>Currículos e histórico profissional</li>
        <li>Formação acadêmica</li>
        <li>Área de interesse profissional</li>
      </ul>
    </section>

    <section class="pp-section">
      <h2>3. Como Usamos Seus Dados</h2>
      <ul>
        <li>Processar matrículas e rematrículas</li>
        <li>Comunicar informações escolares</li>
        <li>Enviar boletins e relatórios</li>
        <li>Gerenciar processos seletivos</li>
        <li>Agendar visitas e reuniões</li>
        <li>Melhorar nossos serviços educacionais</li>
        <li>Cumprir obrigações legais</li>
      </ul>
    </section>

    <section class="pp-section">
      <h2>4. Compartilhamento de Dados</h2>
      <p><strong>Seus dados NÃO são comercializados</strong> e só são compartilhados quando necessário para:</p>
      <ul>
        <li>Órgãos públicos (conforme exigência legal)</li>
        <li>Sistemas de segurança escolar</li>
        <li>Plano de saúde escolar (quando aplicável)</li>
        <li>Transporte escolar (apenas informações necessárias)</li>
      </ul>
    </section>

    <section class="pp-section">
      <h2>5. Armazenamento e Segurança</h2>
      <ul>
        <li>Dados armazenados em servidores seguros</li>
        <li>Acesso restrito a funcionários autorizados</li>
        <li>Criptografia de dados sensíveis</li>
        <li>Backups regulares</li>
        <li>Políticas de senha fortes</li>
      </ul>
    </section>

    <div class="pp-contact">
      <h3>Contato do Encarregado de Dados</h3>
      <p><strong>E-mail:</strong> privacidade@escolaana.com.br</p>
      <p><strong>Telefone:</strong> (61) 3393-4173</p>
      <p><strong>Endereço:</strong> Qr 208 Conjunto a Lotes 11/12/13 e 34/35 S/N, Brasília, DF, 72504-401</p>
    </div>

    <section class="pp-section">
      <h2>6. Seus Direitos</h2>
      <ul>
        <li>Acessar, corrigir ou excluir seus dados</li>
        <li>Revogar consentimentos</li>
        <li>Solicitar portabilidade</li>
      </ul>
    </section>

    <div class="pp-footer">
      <a href="{{ url('/') }}" class="pp-back-btn">← Voltar ao Site Principal</a>
      <p>© 2025 Escola Ana Clara. Todos os direitos reservados.</p>
    </div>

  </div>
</main>
@endsection
