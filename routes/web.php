<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'MatchController@index')->name('pages.home');
Route::get('leagues', 'LeagueController@index')->name('pages.leagues');
Route::get('leagues/{league_tag}', 'LeagueController@show')->name('pages.league');
Route::get('leagues/{league_tag}/teams/{team_tag}', 'TeamController@show')->name('pages.team');
Route::get('matches/{match}/{ht_tag}-vs-{at_tag}', 'MatchController@show')->name('pages.match');