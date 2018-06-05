<?php

/**
 * ToGo App Controllers
 * All route names are prefixed with 'frontend.'.
 */

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'togo.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'App', 'as' => 'app.'], function () {
        /*
         * Agave AngularJS specific routes
         */
//        Route::any('/app', 'AppController@index')->name('index');
        Route::get('togo', 'AppController@index')->name('index');

    });
});
