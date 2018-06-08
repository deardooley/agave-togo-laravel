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
    ]

];