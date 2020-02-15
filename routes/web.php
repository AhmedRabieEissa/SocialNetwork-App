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


Route::group(['middleware'=>['web']],function (){

    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/dashboard',[
        'uses'=>'PostController@getDashboard',
        'as'=>'dashboard',
        'middleware'=>'auth'
    ]);

    Route::post('/signUp',[
        'uses'=>'UserController@postSignUp',
        'as'=>'signUp',
    ]);

    Route::post('/signIn',[
        'uses'=>'UserController@postSignIn',
        'as'=>'signIn',
    ]);

    Route::get('logout',[
        'uses'=>'PostController@getLogOut',
        'as'=>'logout'
    ]);

    Route::get('/account',[
        'uses'=>'PostController@getAccount',
        'as'=>'account'
    ]);

    Route::post('/updateAccount',[
       'uses'=>'PostController@postSaveAccount',
       'as'=>'account.save'
    ]);

    Route::get('/accountImage',[
        'uses'=>'PostController@getUserImage',
        'as'=>'account.image'
    ]);

    Route::post('/creatPost',[
        'uses'=>'PostController@postCreatePost',
        'as'=>'create.post',
        'middleware'=>'auth'
    ]);

    Route::get('/postDelete/{post_id}',[
       'uses'=>'PostController@getPostDelete',
       'as'=>'post.delete',
        'middleware'=>'auth'
    ]);
});
