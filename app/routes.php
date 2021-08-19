<?php

use Illuminate\Support\Facades\Response;


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

// Route::get('/', function()
// {
// 	echo "hlpo";
// });




//Posts Data Mainupaltion Routes
Route::get('/posts', 'BlogController@index');
Route::Post('post/store','BlogController@store');
Route::get('post/posts/{id}', 'BlogController@show');
Route::put('post/update/{id}','BlogController@update');
Route::delete('post/delete/{id}', 'BlogController@destroy');


//Comments Routes
Route::get('/comments', 'CommentController@index');
Route::post('/comment/store', 'CommentController@store');
Route::delete('/comment/delete/{id}', 'CommentController@destroy');
Route::put('/comment/update/{id}', 'CommentController@update');



//User Routes
Route::post('/user/store','UserController@signup');
Route::post('/user/login','UserController@login');

