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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/online-user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::apiResource('child', 'ChildController');
    Route::apiResource('point', 'PointController');
    Route::apiResource('presence', 'PresenceController');
    Route::apiResource('user', 'UserController');

    Route::group(['prefix' => 'child'], function() {
        Route::get('/generate-qrcode/{id}', 'ChildController@generateQrCode');
        Route::get('/download-qrcode/{id}', 'ChildController@downloadQrCode');
    });

    Route::group(['prefix' => 'export'], function() {
        Route::get('/export-template-point', 'ChildController@exportTemplatePoint');
    });

    Route::group(['prefix' => 'import'], function() {
        Route::post('/point', 'PointController@import');
    });

    Route::group(['prefix' => 'presence'], function() {
        Route::get('/show-child/{child_id}', 'PresenceController@showChild');
    });

    Route::group(['prefix' => 'user'], function() {
        Route::patch('/update-password/{id}', 'UserController@updatePassword');
    });
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
