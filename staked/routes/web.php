<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TicketController;
use App\Http\Controllers\BannedTeamController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JournalController; 
use App\Http\Controllers\PlannedBetController;

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/', [AuthController::class, 'showLogin'])->name('login.form');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::group(['middleware'=>['auth','role:admin|bettor']],function () { 
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('teams', TeamController::class);
    // routes/web.php
    Route::get('review/teams', [TeamController::class, 'review'])->name('review.teams');

    Route::resource('tickets', TicketController::class);
    Route::resource('banned-teams', BannedTeamController::class);
    Route::post('tickets/{ticket}/results', [TicketController::class, 'updateResults'])->name('tickets.updateResults');
    Route::post('/tickets/{ticket}/update-notes', [TicketController::class, 'updateNotes'])->name('tickets.updateNotes');
    // routes/web.php
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');

    
    Route::get('/journals/calendar', [JournalController::class, 'kalendar'])->name('journals.calendar');
    Route::resource('journals', JournalController::class);
    Route::resource('planned-bets', PlannedBetController::class);


});    