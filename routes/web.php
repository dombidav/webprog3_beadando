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

Route::get('profile', 'UserController@profile')->name('user.profile');
Route::get('profile/edit', 'UserController@edit')->name('user.edit');
Route::put('profile/update', 'UserController@update')->name('user.update');
Route::get('u/{username}', 'UserController@show')->name('user.show');
Route::get('api/user/s/{name}', 'UserController@search')->name('api.user.search-url');
Route::get('api/user/s', 'UserController@search')->name('api.user.search');

Route::get('user/mail', 'MailController@inbox')->name('user.inbox');

Route::resource('mails', 'MailController')->except(['index']);
Route::post('mailing/inbox', 'MailController@indexInbox')->name('mails.index.inbox');
Route::post('mailing/sent', 'MailController@indexSent')->name('mails.index.sent');

Route::resource('projects', 'ProjectController');
Route::delete('p/members', 'ProjectController@memberRemove')->name('projects.members.remove');
Route::post('p/members', 'ProjectController@memberAdd')->name('projects.members.add');

Route::resource('tasks', 'TaskController');
Route::get('projects/{project_id}/export', 'ProjectController@export')->name('projects.export')->where('task_id', '[0-9]+');
Route::get('api/t/{id}', 'TaskController@apiShow')->name('api.task.show');
Route::put('api/t/update', 'TaskController@update')->name('api.task.update');
