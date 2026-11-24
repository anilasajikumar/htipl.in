<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'API\UserAuthController@login');

Route::get('course-category', 'API\DashBoardController@CourseCategory');
Route::post('course-list', 'API\DashBoardController@CourseByCategory');
Route::post('course-details', 'API\DashBoardController@courseDetails');
Route::post('enquiry', 'API\DashBoardController@Enquiry');
Route::get('centers', 'API\DashBoardController@Centers');
Route::post('courses', 'API\DashBoardController@CourseByCenter');

Route::group(['middleware' =>['auth:api']],function(){
	Route::post('change-password', 'API\UserAuthController@changePassword');
	Route::get('profile', 'API\UserAuthController@profile');
	Route::get('modules', 'API\StudentController@Modules');
	Route::post('videos', 'API\StudentController@getAllVideoMedias');
	Route::post('pdf', 'API\StudentController@getAllPdfMedias');
	Route::post('links', 'API\StudentController@getAllMediaLinks');
	Route::get('alerts', 'API\StudentController@getAlerts');
	Route::get('downloads', 'API\StudentController@getDownloads');
});

