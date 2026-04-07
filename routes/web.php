<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\PublicCurriculoController;
use App\Http\Controllers\PublicAgendamentoController;
use App\Http\Controllers\AdminAgendamentoController;
use App\Http\Controllers\AdminCurriculoController;
use App\Http\Controllers\PublicPreMatriculaController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSiteController;
use App\Http\Controllers\AdminContatoController;
use App\Http\Controllers\AdminFormController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\ListaMateriaisController;


/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

// Página inicial
Route::get('/', fn () => view('site.home'));

// Páginas institucionais
Route::get('/historia', [SiteController::class, 'historia'])->name('historia');
Route::view('/estrutura', 'site.estrutura')->name('estrutura');
Route::view('/normas', 'site.normas')->name('normas');
Route::get('/bercario', [SiteController::class, 'bercario'])->name('bercario');
Route::get('/educacao-infantil', [SiteController::class, 'educacaoInfantil'])->name('educacao.infantil');
Route::get('/ensino-fundamental', [SiteController::class, 'ensinoFundamental'])->name('ensino.fundamental');
Route::view('/diferencial', 'site.diferencial')->name('diferencial');

// Contato
Route::get('/contatos', [ContatoController::class, 'index'])->name('contatos');

// Trabalhe conosco
Route::get('/trabalhe-conosco', [PublicCurriculoController::class, 'showForm'])->name('trabalhe_conosco.form');
Route::post('/trabalhe-conosco', [PublicCurriculoController::class, 'submit'])->name('trabalhe_conosco.submit');

// Agendar visita
Route::get('/agendar-visita', [PublicAgendamentoController::class, 'form'])->name('agendar.form');
Route::post('/agendar-visita', [PublicAgendamentoController::class, 'submit'])->name('agendar.submit');

// Eventos públicos
Route::get('/eventos', [PublicEventController::class, 'index'])->name('site.eventos');

// API galeria (correta)
Route::get('/eventos-json/{id}', function($id){
    $event = \App\Models\Event::with('images')->findOrFail($id);

    return response()->json([
        'dados' => [
            'galeria' => $event->images->map(fn($img) => [
                'caminho_imagem' => asset('storage/'.$img->image_path),
                'legenda' => $img->caption,
            ])
        ]
    ]);
});

// Pré-matrícula
Route::get('/pre-matricula', [PublicPreMatriculaController::class, 'form'])->name('prematricula.form');
Route::post('/pre-matricula', [PublicPreMatriculaController::class, 'submit'])->name('prematricula.submit');

// Políticas
Route::view('/politica-privacidade', 'site.politica-privacidade')->name('politica');
Route::view('/termos-uso', 'site.termos-uso')->name('termos.uso');


/*
|--------------------------------------------------------------------------
| Login Admin
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminAuthController::class, 'formLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.autenticar');
Route::get('/admin/esqueci-senha', [AdminAuthController::class, 'formEsqueciSenha'])->name('admin.esqueci');
Route::post('/admin/esqueci-senha', [AdminAuthController::class, 'enviarLinkRecuperacao'])->name('admin.enviarLink');
Route::get('/admin/redefinir-senha/{token}', [AdminAuthController::class, 'formRedefinirSenha'])->name('admin.redefinir');
Route::post('/admin/redefinir-senha', [AdminAuthController::class, 'salvarNovaSenha'])->name('admin.salvarSenha');


/*
|--------------------------------------------------------------------------
| Área Admin (PROTEGIDA)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:admin')
    ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');


    // EVENTOS
    Route::get('/events/json', [EventController::class, 'index'])->name('events.json');

    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/toggle-active', [EventController::class, 'toggleActive'])->name('events.toggleActive');

    // CURRÍCULOS
    Route::get('/curriculos', [AdminCurriculoController::class, 'index'])->name('curriculos.index');
    Route::get('/curriculos/{id}', [AdminCurriculoController::class, 'show'])->name('curriculos.show');
    Route::get('/curriculos/{id}/download', [AdminCurriculoController::class, 'download'])->name('curriculos.download');

    // AGENDAMENTOS
    Route::get('/agendamentos', [AdminAgendamentoController::class, 'index'])->name('agendamentos.index');
    Route::get('/agendamentos/{agendamento}', [AdminAgendamentoController::class, 'show'])->name('agendamentos.show');

    // SITE CONFIG
    Route::get('/site', [AdminSiteController::class, 'index'])->name('site');
    Route::post('/site', [AdminSiteController::class, 'salvar'])->name('site.salvar');

    // CONTATOS
    Route::get('/contatos', [AdminContatoController::class, 'index'])->name('contatos');
    Route::post('/contatos/salvar', [AdminContatoController::class, 'salvar'])->name('contatos.salvar');

    // FORMULÁRIOS
    Route::get('/formularios/curriculos', [AdminFormController::class, 'curriculos'])->name('formularios.curriculos');
    Route::get('/formularios/prematriculas', [AdminFormController::class, 'prematriculas'])->name('formularios.prematriculas');
    Route::get('/formularios/agendamentos', [AdminFormController::class, 'agendamentos'])->name('formularios.agendamentos');
    Route::get('/formulario/{tipo}/{id}', [AdminFormController::class, 'detalhes'])->name('formularios.detalhes');
    Route::get('/formulario/curriculo/download/{id}', [AdminFormController::class, 'downloadCurriculo'])->name('formularios.curriculo.download');

    Route::post('/formularios/agendamentos/confirmar/{id}', [AdminFormController::class, 'confirmarAgendamento'])
        ->name('formularios.agendamentos.confirmar');

   // LISTA DE MATERIAIS - CERTO
    Route::post('/lista-materiais', [ListaMateriaisController::class, 'salvar'])
    ->name('lista_materiais.salvar');

    Route::delete('/lista-materiais/remover', [ListaMateriaisController::class, 'removerArquivo'])
        ->name('lista_materiais.remover');

    Route::post('/lista-materiais/editar-nomes', [ListaMateriaisController::class, 'editarNomes'])
    ->name('lista_materiais.editarNomes');




});
