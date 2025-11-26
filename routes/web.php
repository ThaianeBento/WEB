<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('animais', \App\Http\Controllers\AnimalController::class);
Route::resource('tutores', \App\Http\Controllers\TutorController::class);
Route::resource('convenios', \App\Http\Controllers\ConvenioController::class);
Route::resource('agenda', \App\Http\Controllers\AgendaController::class);
Route::get('/adotar', [\App\Http\Controllers\AnimaisDoacaoController::class, 'index'])->name('adotar.index');
Route::resource('doacoes', \App\Http\Controllers\DoacaoController::class);
Route::resource('empresas', \App\Http\Controllers\EmpresaController::class);
Route::resource('veterinarios', \App\Http\Controllers\VeterinarioController::class);
Route::resource('mutiroes', \App\Http\Controllers\MutiraoController::class);
Route::post('mutiroes/{id}/veterinarios', [\App\Http\Controllers\MutiraoController::class, 'addVeterinario']);
Route::delete('mutiroes/{id}/veterinarios/{veterinarioId}', [\App\Http\Controllers\MutiraoController::class, 'removeVeterinario']);
Route::post('agenda/{id}/checkin', [\App\Http\Controllers\AgendaController::class, 'checkIn'])->name('agenda.checkin');
Route::post('convenios/{id}/precos', [\App\Http\Controllers\ConvenioController::class, 'addPreco']);
Route::delete('convenios/{id}/precos/{precoId}', [\App\Http\Controllers\ConvenioController::class, 'removePreco']);
Route::get('animais/{id}/contrato', function ($id) {
    $animal = \App\Models\Animal::findOrFail($id);
    return view('animais.contrato', ['animal' => $animal]);
})->name('animais.contrato');

Route::get('relatorios/mutirao/{id}', [\App\Http\Controllers\RelatorioController::class, 'mutirao'])->name('relatorios.mutirao');
Route::get('relatorios/convenios/export', [\App\Http\Controllers\RelatorioController::class, 'exportConvenios'])->name('relatorios.convenios.export');

Route::get('/acesso-interno', [\App\Http\Controllers\InternalAccessController::class, 'index'])->name('internal.login');
Route::post('/acesso-interno', [\App\Http\Controllers\InternalAccessController::class, 'login'])->name('internal.login.post');
Route::get('/painel-interno', [\App\Http\Controllers\InternalAccessController::class, 'dashboard'])->name('internal.dashboard');
Route::view('/sobre-nos', 'sobre-nos')->name('sobre-nos');
Route::view('/servicos', 'servicos')->name('servicos');
