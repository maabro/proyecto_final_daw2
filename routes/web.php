<?php

use Illuminate\Support\Facades\Route;

/**
 * Ruta para mostrar la pagina de inicio
 */
Route::get('/', 'MatchController@index')->name('pages.home');
/**
 * Ruta para mostrar la pagina de ligas
 */
Route::get('leagues', 'LeagueController@index')->name('pages.leagues');
/**
 * Ruta para mostrar la pagina de una liga
 */
Route::get('leagues/{league_tag}', 'LeagueController@show')->name('pages.league');
/**
 * Ruta para mostrar la pagina de un equipo
 */
Route::get('leagues/{league_tag}/teams/{team_tag}', 'TeamController@show')->name('pages.team');
/**
 * Ruta para mostrar la pagina de un partido
 */
Route::get('matches/{match}/{ht_tag}-vs-{at_tag}', 'MatchController@show')->name('pages.match');