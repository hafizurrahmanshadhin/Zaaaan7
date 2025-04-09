<?php

declare(strict_types=1);

return [
    /*
     * ------------------------------------------------------------------------
     * Default Firebase project
     * ------------------------------------------------------------------------
     */

    'default' => env('FIREBASE_PROJECT', 'app'),

    /*
     * ------------------------------------------------------------------------
     * Firebase project configurations
     * ------------------------------------------------------------------------
     */

    'projects' => [
        'app' => [

            /*
             * ------------------------------------------------------------------------
             * Credentials / Service Account
             * ------------------------------------------------------------------------
             *
             * In order to access a Firebase project and its related services using a
             * server SDK, requests must be authenticated. For server-to-server
             * communication this is done with a Service Account.
             *
             * If you don't already have generated a Service Account, you can do so by
             * following the instructions from the official documentation pages at
             *
             * https://firebase.google.com/docs/admin/setup#initialize_the_sdk
             *
             * Once you have downloaded the Service Account JSON file, you can use it
             * to configure the package.
             *
             * If you don't provide credentials, the Firebase Admin SDK will try to
             * auto-discover them
             *
             * - by checking the environment variable FIREBASE_CREDENTIALS
             * - by checking the environment variable GOOGLE_APPLICATION_CREDENTIALS
             * - by trying to find Google's well known file
             * - by checking if the application is running on GCE/GCP
             *
             * If no credentials file can be found, an exception will be thrown the
             * first time you try to access a component of the Firebase Admin SDK.
             *
             */

            // 'credentials' => env('FIREBASE_CREDENTIALS', env('GOOGLE_APPLICATION_CREDENTIALS')),
            // 'credentials' => [
            //     "type"=> "service_account",
            //     "project_id"=> "fir-pushnotification-4848e",
            //     "private_key_id"=> "4d9a23b00dbab5e066eb84f0933d937e145650cd",
            //     "private_key"=> "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCv8wrw2PPJu0Y6\npopjiUERPPH+rydYyaHg6lVGwEVL6V9IRAft7bqlx1DBMp5/E0LKPIaFjRjrmD0N\nnff8BWYwMVYoy2xbowF/rcvyOIllU3C36ZtlYAGC5zKoXyJDQ4V4sqoSKPDTHIU7\nK7XXqhd+dFvgC6DEFxAyBvv2kdmDIDeeN8QqNAUkEbl7yWHsxOqdydgmuz3wYHpv\nmcPs4XU05tvnBqwsQKaEafFAlJ84Y3kI0vgnLv+AZQ+NE+UiXqCoHK2BNcK7BQrN\nFBsRUaIX7GhQ0Lzw1FvKs8SFaw4Y/pl89mTWq521vQB/R6R8DQTjaCMKxM1hhgvP\nFNodSkDhAgMBAAECgf8WgkEkDp0hcZPKbQPHOAfa7LEIo9+kvCa5X0EJjA9RZsmJ\ntSpOhdsa2iS6kn80QoKI3LVY4HQPr6of09WlqAsqnyUmkt+J2ZCXhORSWGk7TTFe\nVcRLc7y9wlX4tDLt5/VrO3AGYrZsS3m/2BerP1dCFiCqyNIIQ+sOe1ZAdOgengoR\n8rubA88SvVQTjnMREksmt94REZ1ZWy43y5q37uY0Fc+7GFTq71UzJv9nVU4uPs1S\nLCvOapjTuqo6qMkzZC428FzUCy6QNHRtP2FPhp7rr7Vk/4o+QcZpcn+aPlu+llNp\nAQImhgbWEMY7Jd5W6ss94v2yEXq6YMkbCTFqTgECgYEA4y56tCCPzM5AcdZkLQhh\nNMUKGRuSSv8x4eA8uTtd/oUydCLbkrtIQSADkMpPwz5RECiW3p2F+ykFNTYdfmnU\nT9m9qhVl3mnlruLrClLpoWzFP4M84M2WeVfYm8bXon22F6bcVPaDaFdcgEXzw3wy\nHZ58swpRAiW+pKd4q+pucqECgYEAxkTYAfBBOZnV9Q3eKiifbcE02iEniBpywvkU\nK86IZ/BQn+v7ta1rsI2N3wwcJCx8El901U5ZppdEjnOx4u3fRjUCj/0nwE4ZWuK3\nRwGVfDOACtuYR6+TuguAAznArDA6RzsYvovgeOhndCJ8I4pTBUtTJRlkvyVxT9T5\nmg+zZkECgYEAvzTkc2ygezjwxp8yKzDNV7OrXxx0kYid/EVV9nUAFHMY1uRrt+DG\n3IFMXvXYEjUF1zrCWFVuacjJqFKGmloKJrbVyiw+U+b/OKWmO0czefjpPx5/A5ol\nVrXYCqxd21ZBB0EaWqwsR4qXwSKfGt4R9BnrTGmXat5HyZ9mkhM6qGECgYEAvYEv\ntSqeLSAMkJ0gq8sIFy+EBLmLv1sINbM8xGIznqTjavdzLsMDG00xPO+mNi0OqcDz\nOq4YolITBNUwQWZ68e/Y8ydUx0nekjAAXa314zCWQcqCUoJPAJPdVzfsIKg4C71A\neV/YvbfkqewMGywrDfRhFCShVtHC7Dr0F3zKTAECgYEA0x1GuwJWkQnDMtATvUtg\n8XEtP4ZgsQoqrJA8kKGXi68sQ8jFbQXHU8P/PtJUEMS2+nzFJQUwRPs3GX/LCg2u\naR3FnkSDgU2awNsbX9VKPasD60QH0vEl8ntgpQOvGC3lu3UBbZuQ3328o502iTYj\nUUUzZ5DbD9JWeiExry5d3Nw=\n-----END PRIVATE KEY-----\n",
            //     "client_email"=> "firebase-adminsdk-fbsvc@fir-pushnotification-4848e.iam.gserviceaccount.com",
            //     "client_id"=> "113440913486123020299",
            //     "auth_uri"=> "https://accounts.google.com/o/oauth2/auth",
            //     "token_uri"=> "https://oauth2.googleapis.com/token",
            //     "auth_provider_x509_cert_url"=> "https://www.googleapis.com/oauth2/v1/certs",
            //     "client_x509_cert_url"=> "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-fbsvc%40fir-pushnotification-4848e.iam.gserviceaccount.com",
            //     "universe_domain"=> "googleapis.com"
            // ],

            'credentials'         => storage_path('app/firebase-auth.json'),

            /*
             * ------------------------------------------------------------------------
             * Firebase Auth Component
             * ------------------------------------------------------------------------
             */

            'auth' => [
                'tenant_id' => env('FIREBASE_AUTH_TENANT_ID'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firestore Component
             * ------------------------------------------------------------------------
             */

            'firestore' => [

                /*
                 * If you want to access a Firestore database other than the default database,
                 * enter its name here.
                 *
                 * By default, the Firestore client will connect to the `(default)` database.
                 *
                 * https://firebase.google.com/docs/firestore/manage-databases
                 */

                // 'database' => env('FIREBASE_FIRESTORE_DATABASE'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Realtime Database
             * ------------------------------------------------------------------------
             */

            'database' => [

                /*
                 * In most of the cases the project ID defined in the credentials file
                 * determines the URL of your project's Realtime Database. If the
                 * connection to the Realtime Database fails, you can override
                 * its URL with the value you see at
                 *
                 * https://console.firebase.google.com/u/1/project/_/database
                 *
                 * Please make sure that you use a full URL like, for example,
                 * https://my-project-id.firebaseio.com
                 */

                'url' => env('FIREBASE_DATABASE_URL'),

                /*
                 * As a best practice, a service should have access to only the resources it needs.
                 * To get more fine-grained control over the resources a Firebase app instance can access,
                 * use a unique identifier in your Security Rules to represent your service.
                 *
                 * https://firebase.google.com/docs/database/admin/start#authenticate-with-limited-privileges
                 */

                // 'auth_variable_override' => [
                //     'uid' => 'my-service-worker'
                // ],

            ],

            'dynamic_links' => [

                /*
                 * Dynamic links can be built with any URL prefix registered on
                 *
                 * https://console.firebase.google.com/u/1/project/_/durablelinks/links/
                 *
                 * You can define one of those domains as the default for new Dynamic
                 * Links created within your project.
                 *
                 * The value must be a valid domain, for example,
                 * https://example.page.link
                 */

                'default_domain' => env('FIREBASE_DYNAMIC_LINKS_DEFAULT_DOMAIN'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Cloud Storage
             * ------------------------------------------------------------------------
             */

            'storage' => [

                /*
                 * Your project's default storage bucket usually uses the project ID
                 * as its name. If you have multiple storage buckets and want to
                 * use another one as the default for your application, you can
                 * override it here.
                 */

                'default_bucket' => env('FIREBASE_STORAGE_DEFAULT_BUCKET'),

            ],

            /*
             * ------------------------------------------------------------------------
             * Caching
             * ------------------------------------------------------------------------
             *
             * The Firebase Admin SDK can cache some data returned from the Firebase
             * API, for example Google's public keys used to verify ID tokens.
             *
             */

            'cache_store' => env('FIREBASE_CACHE_STORE', 'file'),

            /*
             * ------------------------------------------------------------------------
             * Logging
             * ------------------------------------------------------------------------
             *
             * Enable logging of HTTP interaction for insights and/or debugging.
             *
             * Log channels are defined in config/logging.php
             *
             * Successful HTTP messages are logged with the log level 'info'.
             * Failed HTTP messages are logged with the log level 'notice'.
             *
             * Note: Using the same channel for simple and debug logs will result in
             * two entries per request and response.
             */

            'logging' => [
                'http_log_channel' => env('FIREBASE_HTTP_LOG_CHANNEL'),
                'http_debug_log_channel' => env('FIREBASE_HTTP_DEBUG_LOG_CHANNEL'),
            ],

            /*
             * ------------------------------------------------------------------------
             * HTTP Client Options
             * ------------------------------------------------------------------------
             *
             * Behavior of the HTTP Client performing the API requests
             */

            'http_client_options' => [

                /*
                 * Use a proxy that all API requests should be passed through.
                 * (default: none)
                 */

                'proxy' => env('FIREBASE_HTTP_CLIENT_PROXY'),

                /*
                 * Set the maximum amount of seconds (float) that can pass before
                 * a request is considered timed out
                 *
                 * The default time out can be reviewed at
                 * https://github.com/kreait/firebase-php/blob/6.x/src/Firebase/Http/HttpClientOptions.php
                 */

                'timeout' => env('FIREBASE_HTTP_CLIENT_TIMEOUT'),

                'guzzle_middlewares' => [],
            ],
        ],
    ],
];
