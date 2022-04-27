<?php
use App\Http\Livewire\PhoneBookLivewireController;

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/',   PhoneBookLivewireController   ::class) ->name('phonebook');


//easy clear cache
Route::get('/clear', function() {
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return 'Cleared';
});
