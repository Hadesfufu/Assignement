<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/projects', 'ProjectsController@index');

    Route::get('/projects/add',
        ['as' => 'projects_add', 'uses' => 'ProjectsController@addIndex']);

    Route::post('/projects/add',
        ['as' => 'projects_add_apply', 'uses' => 'ProjectsController@add']);

    Route::get('/projects/unOld/{id}', 'ProjectsController@unOld');

    Route::get('/projects/setOld/{id}', 'ProjectsController@setOld');

    Route::get('/projects/{id}', 'ProjectsController@details');

    Route::get('/projects/edit/{id}',
        ['as' => 'projects_edit', 'uses' => 'ProjectsController@editIndex']);

    Route::post('/projects/edit/{id}',
        ['as' => 'projects_edit_apply', 'uses' => 'ProjectsController@edit']);

    Route::get('/projects/addMember/{id}', 'ProjectsController@addMember');

    Route::get('/projects/removeMember/{id}', 'ProjectsController@removeMember');

    Route::get('/members', 'MembersController@index');

    Route::get('/members/{id}', 'MembersController@details');

    Route::get('/members/setAdministrator/{id}', 'MembersController@setAdmin');

    Route::get('/members/setOld/{id}', 'MembersController@setOld');

    Route::get('/members/unOld/{id}', 'MembersController@unOld');

    Route::get('/publications', 'PublicationsController@index');

    Route::get('/', function () { return view('welcome');  });

    Route::get('/settings',
        ['as' => 'settings', 'uses' => 'SettingsController@index']);

    Route::post('settings',
        ['as' => 'settings_apply', 'uses' => 'SettingsCont1roller@update']);

    Route::get('old/members', 'MembersController@oldDisplay');

    Route::get('old/projects', 'ProjectsController@oldDisplay');
});