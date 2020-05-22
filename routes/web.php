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

Route::get('home', 'HomeController@index')->name('home');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('user/profile', 'UserController@profile')->name('user.profile');
Route::get('user/profile/edit', 'UserController@edit')->name('user.edit');
Route::put('user/profile/update', 'UserController@update')->name('user.update');
Route::get('user/profile/show/{username}', 'UserController@show')->name('user.show');
Route::get('api/user/s/{name}', 'UserController@search')->name('api.user.search-url');
Route::get('api/user/s', 'UserController@search')->name('api.user.search');

Route::get('user/mail', 'MailController@inbox')->name('user.inbox');

Route::resource('mails', 'MailController')->except(['index']);
Route::post('mailing/inbox', 'MailController@indexInbox')->name('mails.index.inbox');
Route::post('mailing/sent', 'MailController@indexSent')->name('mails.index.sent');

Route::get('projects', 'ProjectController@index')->name('project');
Route::get('project/{id}', 'ProjectController@show')->name('project.show')->where('id', '[0-9]+');
Route::get('project/create', 'ProjectController@create')->name('project.create');
Route::post('project/create', 'ProjectController@store')->name('project.store');
Route::get('project/edit/{id}', 'ProjectController@edit')->name('project.edit')->where('id', '[0-9]+');
Route::put('project/edit/{id}', 'ProjectController@update')->name('project.update')->where('id', '[0-9]+');
Route::get('project/delete/{id}', 'ProjectController@delete')->name('project.delete')->where('id', '[0-9]+');
