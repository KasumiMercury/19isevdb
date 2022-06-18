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

Route::GET('/get/newData', 'App\Http\Controllers\PlayerController@newData');

Route::GET('/snsinfo/all', 'App\Http\Controllers\SnsController@snsAll');
Route::GET('/snsinfo/full', 'App\Http\Controllers\SnsController@snsFull');
Route::GET('/snsinfo/{id}', 'App\Http\Controllers\SnsController@snsMember');

Route::GET('/register/show/{id}', 'App\Http\Controllers\AccountController@registerShow');
Route::POST('/questionnaire', 'App\Http\Controllers\AccountController@postIsShow');

Route::GET('/liveinfo/status', 'App\Http\Controllers\SnsController@getStatus')->name('liveinfo.status');
Route::GET('/liveinfo/full', 'App\Http\Controllers\SnsController@getLiveInfo');

Route::put('/status/player', 'App\Http\Controllers\DataController@editStatus')->name('player.status');
Route::put('/edit/player', 'App\Http\Controllers\DataController@playerChange')->name('player.change');

Route::POST('/add/twitter', 'App\Http\Controllers\DataController@addTwitter')->name('add.twitter');
Route::POST('/add/clip', 'App\Http\Controllers\DataController@addClip')->name('add.clip');
Route::POST('/add/youtube', 'App\Http\Controllers\DataController@addYoutube')->name('add.youtube');
Route::POST('/add/youtubeclip', 'App\Http\Controllers\DataController@addYTclip')->name('add.YTclip');

Route::POST('/add/{id}/like', 'App\Http\Controllers\AccountController@addLike')->name('add.like');
Route::POST('/delete/{id}/dislike', 'App\Http\Controllers\AccountController@DisLike')->name('delete.like');

