<?php
use YourName\Messaging\Http\Controllers\MessageController;

Route::middleware('auth')->prefix('messaging')->name('messaging.')->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('index');
    Route::post('/start', [MessageController::class, 'start'])->name('start');
    Route::get('/{conversation}', [MessageController::class, 'show'])->name('show');
    Route::get('/{conversation}/fetch', [MessageController::class, 'fetch'])->name('fetch');
    Route::post('/{conversation}/messages', [MessageController::class, 'store'])->name('store');
    Route::post('/{conversation}/typing', [MessageController::class, 'typing'])->name('typing');
    Route::get('/{conversation}/typing-status', [MessageController::class, 'typingStatus'])->name('typing.status');
    Route::get('/unread-count', [MessageController::class, 'unreadCount'])->name('messaging.unreadCount');

});
