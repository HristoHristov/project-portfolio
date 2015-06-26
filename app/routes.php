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
Route::post('user/login', 'UserController@login');

Route::post('user', 'UserController@store');

Route::post('user/edit', 'UserController@edit');

Route::post('project/upload-picture', 'ProjectController@uploadPortfolios');

Route::get('project/{path}/delete', 'ProjectController@destroy');

Route::post('project/{path}/upload-picture', 'ProjectController@uploadFile');

Route::post('project', 'ProjectController@store');

Route::post('project/upload-picture/{id}', 'ProjectController@uploadPortfolios');

Route::post('project/{path}/edit', 'ProjectController@edit');

Route::get('user/login', 'UserController@showLoginForm');

Route::get('user/logout', 'UserController@logout');

Route::get('user/create', 'UserController@create');

Route::get('user/edit', 'UserController@showEditForm');

Route::get('project', 'ProjectController@home');

Route::get('project/{id}/public', 'ProjectController@projectSetVisibilityPublic');

Route::get('project/{id}/private', 'ProjectController@projectSetVisibilityPrivate');

Route::get('project/portfolio', 'ProjectController@portfolioIndex');

Route::get('project/repository', 'ProjectController@repositoryIndex');

Route::get('project/repository/edit-repository', 'ProjectController@editRepositoryIndex');

Route::get('project/{id}/repository/{edit?}', 'ProjectController@projectRepository');

Route::get('project/{id}/file/open', 'ProjectController@openFile');

Route::post('project/{id}/edit-name', 'ProjectController@editName');

Route::get('project/{id}/portfolio', 'ProjectController@projectPortfolio');

Route::post('project/{path}/make-dir', 'ProjectController@makeDirectory');


Route::get('/', function()
{
	return View::make('hello');
});
