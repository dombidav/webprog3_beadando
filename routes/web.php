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

Route::resource('projects', 'ProjectController');
Route::resource('tasks', 'TaskController');
