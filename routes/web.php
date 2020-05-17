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
Route::get('/', 'HomeController@index')->name('main');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('projects', 'ProjectController@index')->name('project');
Route::get('project/{id}', 'ProjectController@index')->name('project')->where('id', '[0-9]+');
Route::get('project/create', 'ProjectController@create')->name('project.create');
Route::post('project/create', 'ProjectController@store')->name('project.store');
Route::get('project/edit/{id}', 'ProjectController@create')->name('project.edit')->where('id', '[0-9]+');
Route::put('project/edit/{id}', 'ProjectController@update')->name('project.update')->where('id', '[0-9]+');
Route::get('project/delete/{id}', 'ProjectController@delete')->name('project.delete')->where('id', '[0-9]+');
