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

// ユーザ側画面
Route::group(['prefix' => '/', 'user.', 'namespace' => 'User'], function () {
    Auth::routes();

    Route::get('/', function () {
        return redirect()->route('home');
    });

    Route::get('slack/login', 'Auth\AuthenticateController@callSlackApi');
    Route::get('callback', 'Auth\AuthenticateController@loginBySlackUserInfo');

    Route::post('/register', 'Auth\RegisterController@register');
    Route::get('/register/{query}', 'Auth\RegisterController@showRegistrationForm');

    Route::get('home', 'UserController@index')->name('home');

    Route::get('attendance', 'AttendanceController@index')->name('attendance.index');
    Route::post('attendance', 'AttendanceController@timeStore')->name('attendance.timeStore');
    Route::get('attendance/absent', 'AttendanceController@absentCreate')->name('attendance.absentCreate');
    Route::post('attendance/absent', 'AttendanceController@absentStore')->name('attendance.absentStore');
    Route::get('attendance/modify', 'AttendanceController@modifyCreate')->name('attendance.modifyCreate');
    Route::post('attendance/modify', 'AttendanceController@modifyStore')->name('attendance.modifyStore');
    Route::get('attendance/mypage', 'AttendanceController@showMypage')->name('attendance.mypage');

});

// 管理者側画面
Route::group(['prefix' => 'admin', 'as' => 'admin.' ,'namespace' => 'Admin'], function () {
    Auth::routes();
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

    Route::get('attendance', 'AttendanceController@index')->name('attendance.index');
    Route::get('attendance/show/{id}', 'AttendanceController@show')->name('attendance.show');
    Route::get('attendance/create/{id}', 'AttendanceController@create')->name('attendance.create');
    Route::get('attendance/edit/{id}', 'AttendanceController@edit')->name('attendance.edit');
    Route::post('attendance', 'AttendanceController@store')->name('attendance.store');
    Route::post('attendance/absent', 'AttendanceController@absentStore')->name('attendance.absentStore');
    Route::put('attendance/{id}', 'AttendanceController@update')->name('attendance.update');
    Route::put('attendance/{id}/absent', 'AttendanceController@absentUpdate')->name('attendance.absentUpdate');

    Route::get('report', function () {
        abort(404);
    });
    Route::get('question', function () {
        abort(404);
    });
    Route::get('user', function () {
        abort(404);
    });
    Route::get('adminuser', function () {
        abort(404);
    });
    Route::get('contact', function () {
        abort(404);
    });

    Route::post('password/email', [
        'as' => 'password.email',
        'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
    ]);
    Route::get('password/reset', [
        'as' => 'password.request',
        'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
    ]);
    Route::post('password/reset', [
        'as' => 'password.request',
        'uses' => 'Auth\ResetPasswordController@reset'
    ]);
    Route::get('password/reset/{token}', [
        'as' => 'password.reset',
        'uses' => 'Auth\ResetPasswordController@showResetForm'
    ]);
    Route::post('/register', [
        'as' => 'register',
        'uses' => 'Auth\AdminRegisterController@adminRegister'
    ]);
    Route::get('/register/', 'Auth\AdminRegisterController@showAdminRegistrationForm');
});

