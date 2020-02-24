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






// Auth::routes();

Route::get('file-upload', 'FileUploadController@index');
// Route::post('file-upload/upload', 'FileUploadController@upload')->name('upload');
Route::get('users/search', 'UsersController@search');
Route::get('posts/Show-posts/{limit}', 'postController@Show_post');
Route::group(['middleware' => 'auth'], function () {

    Route::match(['post', 'put'], 'posts/like', 'postController@like');
    Route::post('posts/comment', 'postController@create_Comment');
    Route::get('posts/showComment', 'postController@showComment');
    Route::get('posts/update-comment', 'postController@updateComment');
    Route::get('posts/delete-comment', 'postController@deleteComment');
    Route::get('posts/like-comment', 'postController@likeComment');
    Route::get('posts/reply-comment', 'postController@replyComment');
    Route::get('posts/update-reply', 'postController@updateReply');
    Route::get('posts/delete-reply', 'postController@deleteReply');
    Route::get('posts/Show-Reply-Comment/{id}', 'postController@Show_Reply_Comment');
    Route::get('posts/Show-Comment/{id}/{count}', 'postController@Show_Comment');

    Route::resource('posts', 'postController')->except([
    	'index',
    	'show',
    	'edit',
    	'update',
    ]);



    Route::match(['post', 'delete'], 'users/follow', 'UsersController@follow');
    Route::put('users/update-image', 'UsersController@update_image');
    Route::get('users/Check-email', 'UsersController@check_email');
    Route::get('users/Check-username', 'UsersController@check_username');
    Route::get('users/Check-password', 'UsersController@check_password');
    Route::post('users/update-pwd', 'UsersController@update_pwd');

    Route::get('notification/Mark-All', 'UsersController@markRead');
    Route::get('notification/get-noti', 'UsersController@getNotifications');
    Route::resource('users', 'UsersController')->except([
    	'create',
    	'store',
    	'destroy',
    ]);

});

    Route::group(['prefix'=>'admin'],function(){

        Route::get("/login","back_end\AdminController@loginView");
        Route::post("/login","back_end\AdminController@login");
        Route::post("/password/email","back_end\Auth\ForgotPasswordController@sendResetLinkEmail");
        Route::get("/password/reset","back_end\Auth\ForgotPasswordController@showLinkRequestForm");
        Route::get("/password/reset/{token}","back_end\Auth\ResetPasswordController@showResetForm");
        Route::post("/password/reset","back_end\Auth\ResetPasswordController@reset");
        Route::group(["middleware"=>["admin"]],function(){
            Route::get("/","back_end\AdminController@homePage");
            Route::get("/show-members","back_end\MemberController@Show");
            Route::get("/get-members","back_end\MemberController@getUser");
            Route::get("/add-member","back_end\MemberController@ShowPageAddUser");
            Route::post("/add-member","back_end\MemberController@addUser");
            Route::get("/edit/{id}","back_end\MemberController@ShowPageUpdateUser");
            Route::put("/edit/{id}","back_end\MemberController@updateUser");
            Route::get("/remove/{id}","back_end\MemberController@deleteUser");
        });

    });
//  Route::get('/home', 'HomeController@index')->name('home');
Route::get('/messages/ChatUser/{id}', 'MessageController@chatUser');
Route::get('/messages/messenger', 'MessageController@messenger');
Route::post('messages/upload', 'MessageController@upload')->name('upload');
Route::resource('messages', 'MessageController');
Auth::routes();
Route::get('/home', 'HomeController@index');
Route::get('/', function () {
    return redirect()->to('/home');
});
