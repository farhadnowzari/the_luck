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
Route::as('api.')->group(function() {
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::as('contests.')->prefix('contests')->group(function() {
        Route::get('/', 'ContestsController@listOldContests')->name('list');
        Route::post('/', 'ContestsController@createContest')->name('create');
        Route::get('/get/paused', 'ContestsController@retrieveOpenContest')->name('get_paused_contest');
    });

    Route::as('rounds.')->prefix('rounds')->group(function() {
        Route::post('/start/{roundId}', 'RoundsController@startRound')->name('start');
        Route::post('/evaluate/{roundId}', 'RoundsController@evaluateRound')->name('evaluate');
    });
});