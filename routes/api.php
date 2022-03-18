<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::GET('/liveinfo/status', 'App\Http\Controllers\PlayerController@getStatus')->name('liveinfo.status');
Route::put('/status/player', 'App\Http\Controllers\PlayerController@editStatus')->name('player.status');
Route::put('/edit/player', 'App\Http\Controllers\PlayerController@playerChange')->name('player.change');
Route::POST('/add/twitter', 'App\Http\Controllers\PlayerController@addTwitter')->name('add.twitter');
Route::POST('/add/clip', 'App\Http\Controllers\PlayerController@addClip')->name('add.clip');
Route::POST('/add/youtube', 'App\Http\Controllers\PlayerController@addYoutube')->name('add.youtube');
Route::POST('/add/youtubeclip', 'App\Http\Controllers\PlayerController@addYTclip')->name('add.YTclip');
Route::POST('/add/{id}/like', 'App\Http\Controllers\PlayerController@addLike')->name('add.like');
Route::POST('/delete/{id}/dislike', 'App\Http\Controllers\PlayerController@DisLike')->name('delete.like');