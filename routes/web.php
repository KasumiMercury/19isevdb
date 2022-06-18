<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',[App\Http\Controllers\PlayerController::class, 'TopPage'])->name('TopPage'); 

Route::get('/check', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return redirect('/');
})->name('dashboard'); 

Route::get('/questionnaire', function () {
    return Inertia::render('questionnaire');
}); 

Route::prefix('login/{provider}')->where(['provider'=> 'google'])->group(function(){
    Route::get('/',[App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('sns_login.redirect');
    Route::get('/callback',[App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback'])->name('sns_login.callback');
});

Route::get('/live/info', function () {
    return Inertia::render('LiveInfo');
})->name('live.info'); 

Route::get('/add', function () {
    return Inertia::render('DataAdd');
})->name('data.add'); 

Route::get('/welcome', function () {
    return Inertia::render('WelcomePage');
})->name('welcome.page'); 

Route::middleware(['auth:sanctum', 'verified'])->get('/bookmark',[App\Http\Controllers\PlayerController::class, 'bookMark'])->name('user.book'); 

Route::middleware(['auth:sanctum', 'verified'])->get('/added',[App\Http\Controllers\PlayerController::class, 'addedData'])->name('user.added'); 

Route::get("/my-login", [App\Http\Controllers\Auth\LoginController::class, "index"])->name("myLogin");

Route::get('/edit/{id}',[App\Http\Controllers\DataController::class, 'Edit'])->name('player.edit');

Route::get('/all/{cate}',[App\Http\Controllers\PlayerController::class, 'category'])->name('player.category');

Route::get('/{member}',[App\Http\Controllers\PlayerController::class, 'memberTop'])->name('member.top');

Route::get('/{member}/latest',[App\Http\Controllers\PlayerController::class, 'latest'])->name('member.latest');

Route::get("/{member}/share/{id}", [App\Http\Controllers\PlayerController::class, "sharePlayer"])->name("share.player");

Route::get('/{member}/player/{id}',[App\Http\Controllers\PlayerController::class, 'player'])->name('member.player'); 

Route::get('/{member}/{cate}',[App\Http\Controllers\PlayerController::class, 'memberCate'])->name('member.cate'); 

