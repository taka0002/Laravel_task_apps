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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/blade_sample', function () {
    $title = 'bladeテンプレートのサンプルです';
    $description = 'bladeテンプレートを利用すると、<br>HTML内にPHPの変数を埋め込むことができます。';
    return view('blade_sample',[
        'title' => $title,
        'description' => $description,
    ]);
});

Route::get('/sample_action', 'SampleController@sample_action');

Route::get('/practice', 'SampleController@practice');

Route::get('/message_sample', 'SampleController@message_sample');

Route::get('/message_practice', 'SampleController@message_practice');

Route::get('/blade_example', 'SampleController@blade_example');

Route::get('/messages', 'MessagesController@index');

Route::post('/messages', 'MessagesController@create');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/task_apps', 'Task_appController@index_task_app');

Route::post('/task_apps', 'Task_appController@create');
Auth::routes();

Route::patch('/task_apps', 'Task_appController@update');

Route::delete('/task_apps', 'Task_appController@destroy');

Route::get('/task_apps_category', 'Task_appController@index_task_app_category');

Route::patch('/task_apps_category', 'Task_appController@update');

Route::delete('/task_apps_category', 'Task_appController@destroy');