<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Agave management accounts
     |--------------------------------------------------------------------------
     |
     | We define the accounts the gateway will use to take action on behalf of
     | its users.
     |
     */
    "accounts" => [

        /*
        |--------------------------------------------------------------------------
        | Allowed users
        |--------------------------------------------------------------------------
        |
        | The `service` account is used for things like password resets,
        | new account creation, etc. and requires an adminstrative role within
        | the configured Agave tenant to carry those out.
        |
        */
        "service" => [
            "username" => env("AGAVE_USERNAME"),
            "password" => env("AGAVE_PASSWORD"),
        ],

        /*
        |--------------------------------------------------------------------------
        | Allowed users
        |--------------------------------------------------------------------------
        |
        | The `shared` account is used for managing shared resources and bookkeeping
        | tasks that need to be corrdinated across users. Examples would be granting
        | new users access to a private storage system or app, creating and sharing
        | "project" metadata, and subscribing to shared notifications and permission
        | events.
        |
        */
        "shared" => [
            "username" => env("AGAVE_USERNAME"),
            "password" => env("AGAVE_PASSWORD"),
        ]
    ],


    /*
     |--------------------------------------------------------------------------
     | User access control
     |--------------------------------------------------------------------------
     |
     | Next we configure who can and cannot access this webapp by defining an
     | array of allowed, restricted, and administrative users. Wildcards are
     | supported. By default, all users are allowed to access the webapp and the
     | service account used to perform administrative tasks is the only admin.
     |
     */

    "users" => [
        /*
         |--------------------------------------------------------------------------
         | Allowed users
         |--------------------------------------------------------------------------
         |
         | This is an array of all users to which access should be explicitly granted.
         | app. A wildcard value, *, implies the app should be available to all
         | users unless explicitly listed as in the "users.allowed" or
         | "users.administrators" arrays. By default, any user is allowed to register
         | and use this webapp.
         |
         */
        "allowed" => [ "*" ],

        /*
         |--------------------------------------------------------------------------
         | Restricted users
         |--------------------------------------------------------------------------
         |
         | This is an array of all users that should not be allowed to register or
         | use the webapp. A wildcard value, *, implies the webapp should be restricted
         | to all users unless explicitly listed as in the "allowed_users" or
         | "administrators" arrays.
         |
         */
        "restricted" => [ ],

        /*
         |--------------------------------------------------------------------------
         | Administrative users
         |--------------------------------------------------------------------------
         |
         | This is an array of all the users who should have admin access to the
         | gateway. Use the internal username of the users.
         |
         */
        "administrators" => [ env('AGAVE_USERNAME') ],
    ]
];