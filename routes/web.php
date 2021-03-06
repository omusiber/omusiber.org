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

use App\Doc;


Route::get('/', 'IndexController@index');
Route::post('/','IndexController@store');
Route::group(['prefix' => Config::get('app.loginUrl')], function() {
    Auth::routes();
});

Route::get('projects','IndexController@projects');
Route::get('activities','IndexController@activities');

Route::get('subscribe','MembersController@newMember');
Route::post('subscribe','MembersController@newMembertoDB');

/* MEMBERS */
Route::group(['prefix' => 'members', 'middleware' => 'admin'],function (){
    Route::get('','MembersController@index');
    Route::post('add','MembersController@addMembertoDB');
    Route::get('add','MembersController@addMember');
});


/*  ADMIN   */
Route::group(['prefix' => 'admin', 'middleware' => 'admin'],function(){
    Route::get('','AdminController@index');
    Route::get('messages','AdminController@messages');
    Route::delete('messages','AdminController@deleteMessage');
    Route::get('team', 'AdminController@team');
    Route::post('team', 'AdminController@teamPOST');
    Route::delete('team', 'AdminController@deleteTeam');
    Route::get('users','UserController@index');
    Route::get('users/{id}','UserController@edit');
    Route::post('users/{id}','UserController@update');
    Route::get('about-us','AdminController@aboutUs');
    Route::post('about-us','AdminController@aboutUsPOST');
    Route::get('projects','AdminController@projects');
    Route::post('projects','AdminController@projectsPOST');
    Route::delete('projects','AdminController@deleteProject');
    Route::get('activities','AdminController@activities');
    Route::post('activities','AdminController@activitiesPOST');
    Route::post('activities/update','AdminController@activityUpdate');
    Route::delete('activities', 'AdminController@deleteActivity');
    //Route::get('gallery','AdminController@gallery');
    //Route::post('gallery','AdminController@galleryPOST');
    //Route::delete('gallery','AdminController@deletePhoto');
    Route::get('members','AdminController@members');
    Route::get('categories','AdminController@categories');
});

/*  DOCS   */
Route::group(['prefix' => 'docs'],function (){
    Route::get('','DocsController@index');
    Route::get('add','DocsController@addTool')->middleware('editor');
    Route::post('add','DocsController@store');
    Route::get('add-category','DocsController@addCategory')->middleware('editor');
    Route::post('add-category','DocsController@addCategorytoDB')->middleware('editor');
    Route::get('tool/{tool}','DocsController@displayTool');
    Route::get('tool/{tool}/edit','DocsController@editTool')->middleware('editor');
    Route::post('tool/{tool}/edit','DocsController@updateTool')->middleware('editor');
});


/* CTF */
Route::get('ctf', 'IndexController@ctf');

/* TEST */
Route::get('test', 'IndexController@testpage');