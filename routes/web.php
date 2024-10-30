<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Rota para a página inicial
Route::get('/', [PageController::class, 'home'])->name('home');

// Rota para o dashboard
Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Rotas administrativas
Route::prefix('admin')->group(function() {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('admin.dashboard');
});

// Rotas para geladeiras
Route::prefix('geladeira')->group(function () {
    Route::get('/form/{id}', [PageController::class, 'showGeladeiraForm'])->name('geladeira.form'); // Exibir o formulário
    Route::post('/feedback/{id}', [PageController::class, 'storeFeedback'])->name('geladeira.feedback'); // Armazenar feedback
});

Route::post('/geladeira/store/{id}', [PageController::class, 'storeFeedback'])->name('geladeira.store'); // Armazenar feedback

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::prefix('feedback')->group(function () {
    Route::get('/{geladeira_id}', [FeedbackController::class, 'index'])->name('feedback.index'); // Exibir feedbacks
    Route::post('/{geladeira_id}', [FeedbackController::class, 'store'])->name('feedback.store'); // Armazenar feedback
});

require __DIR__.'/auth.php';
