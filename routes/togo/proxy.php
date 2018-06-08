<?php

/**
 * ToGo App Controllers
 * All route names are prefixed with 'frontend.'.
 */

/*
 * These api proxy controllers require the user to be logged in to the laravel server. The server will
 * inject the users' auth token into the request header and proxy the call to the remote host.
 * All route names are prefixed with 'togo.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires', 'refresh.token', 'activity', 'throttle:1000,1']], function () {
    Route::group(['namespace' => 'Proxy', 'as' => 'proxy.'], function () {
        /*
         * Agave AngularJS specific routes
         */
        Route::any("proxy/{apiPath}",'ProxyController@proxy')
            ->where("apiPath", ".*")
            ->name('index');

    });
});
