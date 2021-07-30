<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\BlogController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('@{username}', 'UserController@show');

Route::get('/search', 'HomeController@search');

Route::middleware('auth')->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('user/edit', 'UserController@edit');
    Route::put('user/edit', 'UserController@update');
    Route::resource('post', PostController::class);

    Route::get('/follow/{user_id}', 'UserController@follow');
    Route::get('/like/{type}/{post_id}', 'LikeController@toggle');

    Route::get('/notification', 'UserController@notification');
    Route::get('/notification/seen', 'UserController@notificationSeen');
    Route::get('/notification/count', 'UserController@notificationCount');
    // comment
    Route::resource('post.comment', CommentController::class)->shallow();

    // Route::post('comment/{post_id}', 'CommentController@store');
    // Route::get('comment/{comment_id}/edit', 'CommentController@edit');
    // Route::put('comment/{comment_id}', 'CommentController@update');
    // Route::get('comment/{comment_id}/delete', 'CommentController@delete');
});
Route::get('/loadmore/{time}', 'HomeController@loadmore');


