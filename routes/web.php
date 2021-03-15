<?php

/**
 * Landing Page
 */

Route::get('/', function () {
    return view('welcome');
});

/**
 * Seller Routes
 */

Route::prefix('/seller')->name('seller.')->namespace('Seller')->group(function(){

    /**
     * Seller Auth
     */

    Route::namespace('Auth')->group(function(){
        //Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
        Route::post('/logout','LoginController@logout')->name('logout');

        //Forgot Password Routes
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        //Reset Password Routes
        Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');

    });

    /**
     * Seller Dashboard
     */

    Route::get('/home', 'HomeController@index')->name('home');

});

/**
 * Admin Routes
 */

Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){

    /**
     * Admin Auth
     */

    Route::namespace('Auth')->group(function(){
        //Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
        Route::post('/logout','LoginController@logout')->name('logout');

        //Forgot Password Routes
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        //Reset Password Routes
        Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');

    });

    /**
     * Admin Dashboard
     */

    Route::get('/home', 'HomeController@index')->name('home');

});


/**
 * Buyer/User Auth
 */

Auth::routes();

/**
 * Buyer/User Dashboard
 */

Route::get('/home', 'HomeController@index')->name('home');

