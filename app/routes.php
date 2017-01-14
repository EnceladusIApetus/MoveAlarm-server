<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/test', 'UserController@getUserData');

Route::post('/login', 'UserController@login');

Route::group(array('prefix' => 'user'), function()
{
	Route::post('update', 'UserController@update');
	Route::post('create', 'UserController@create');
	Route::post('temp_login', 'UserController@tempLogin');
	Route::post('rank', 'UserController@getRank');
	Route::get('topRank', 'UserController@getTopRank');
});

Route::group(array('prefix' => 'group'), function()
{
	Route::post('findByUser', 'GroupController@findByUser');
	Route::post('create', 'GroupController@create');
	Route::post('update', 'GroupController@update');
	Route::post('join', 'GroupController@join');
	Route::get('topRank', 'GroupController@getTopRank');
	Route::post('rank', 'GroupController@getRank');
	Route::post('rankByUser', 'GroupController@getRankByUser');
	Route::post('leave', 'GroupController@leave');
	Route::post('delete', 'GroupController@delete');
	Route::post('addScore', 'GroupController@addScore');
});

Route::get("/event/getEvent", 'EventController@getEvent');
