<?php

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

// Authentification
// Auth::routes();
// Because we don't use full auth system, the following routes is enaught
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('post.login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Tasks list
Route::get('/', 'TaskController@index')
    ->name('task.front');

Route::get('/task', 'TaskController@index')
    ->name('task.index');

Route::group(['middleware' => 'auth', 'prefix' => 'crud'], function () {

// Task view
    Route::get('/task/{id}/view', 'TaskController@view')
        ->where('id', '[0-9]+')
        ->name('task.view');
// Task add form
    Route::get('/task/add', 'TaskController@add')
        ->name('task.add');
// Task edit form
    Route::get('/task/{id}/edit', 'TaskController@edit')
        ->where('id', '[0-9]+')
        ->name('task.edit');
// Task edit save
    Route::put('/task/{id}/save', 'TaskController@save')
        ->where('id', '[0-9]+')
        ->name('task.edit.save');
// Task add save
    Route::post('/task/save', 'TaskController@save')
        ->name('task.add.save');
// Task delete
    Route::delete('/task/delete', 'TaskController@delete')
        ->name('task.delete');
});




// Statuses list
    Route::get('/status', 'StatusController@index')
        ->name('status.index');
// Task view
    Route::get('/status/{id}/view', 'StatusController@view')
        ->where('id', '[0-9]+')
        ->name('status.view');

Route::group(['middleware' => 'auth', 'prefix' => 'crud'], function () {

// Task add form
    Route::get('/status/add', 'StatusController@add')
        ->name('status.add');
// Task edit form
    Route::get('/status/{id}/edit', 'StatusController@edit')
        ->where('id', '[0-9]+')
        ->name('status.edit');
// Task edit save
    Route::put('/status/{id}/save', 'StatusController@save')
        ->where('id', '[0-9]+')
        ->name('status.edit.save');
// Task add save
    Route::post('/status/save', 'StatusController@save')
        ->name('status.add.save');
// Task delete
    Route::delete('/status/delete', 'StatusController@delete')
        ->name('status.delete');

});