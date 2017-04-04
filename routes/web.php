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

Auth::routes();

Route::get('/home', 'HomeController@index');

//This Route is for the webhook jo telestream cloud se aara hai.yeh outside request hai isliye yeh middleware meim nahi ayega
Route::post('/webhook/encoding','EncodingWebhookController@handle'); 

//VideoController outside middleware because anyone can watch videos without being the member assuming ki video public

Route::get('/videos/{video}','VideoController@show');

//VideoViewController outside isliye hai because any unregistered can see a video by which view can be logged
Route::post('/videos/{video}/views','VideoViewController@create');

//for angolia search we use this should be available without authentication
Route::get('/search','SearchController@index');

//votes should be visible to unauthenticated users ko bhi
Route::get('/videos/{video}/votes','VideoVoteController@show');


//waise hi comments should be visible to unauthenticated users ko bhi
Route::get('/videos/{video}/comments','VideoCommentController@index');


Route::get('/subscription/{channel}','ChannelSubscriptionController@show');


Route::get('/channel/{channel}','ChannelController@show');


Route::group(['middleware' => ['auth']] , function() {


	//VideoUploadController
	Route::get('/upload', 'VideoUploadController@index');
	Route::post('/upload', 'VideoUploadController@store');
	//VideoUploadController ends here

	//VideoController
	Route::get('/videos', 'VideoController@index');
	Route::get('/videos/{video}/edit','VideoController@edit');
	Route::post('/videos', 'VideoController@store');
	Route::put('/videos/{video}', 'VideoController@update');
	Route::delete('/videos/{video}', 'VideoController@delete');
	//VideoController Ends Here
	

	//ChannelSettingsController
	Route::get('/channel/{channel}/edit','ChannelSettingsController@edit');
	Route::put('/channel/{channel}/edit','ChannelSettingsController@update');
	//ChannelSettingsController ends Here

	//VideoVoteController 
	Route::post('/videos/{video}/votes', 'VideoVoteController@create');
    Route::delete('/videos/{video}/votes', 'VideoVoteController@delete');
    //VideoVoteController ends here

    //VideoCommentController
	Route::post('/videos/{video}/comments','VideoCommentController@create');
	Route::delete('/videos/{video}/comments/{comment}','VideoCommentController@delete');
	//ends Here VideoCommentController  

	//SubscriptionController
	Route::post('/subscription/{channel}','ChannelSubscriptionController@create');
	Route::delete('/subscription/{channel}','ChannelSubscriptionController@delete');  
	//ends here SubscriptionController
	
});