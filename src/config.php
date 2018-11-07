<?php

/*
|--------------------------------------------------------------------------
| Application config
|--------------------------------------------------------------------------
|
| Define you config values here.
|
*/

return [
    'webhook_verify_token' => getenv('WEBHOOK_VERIFY_TOKEN'),
    'access_token'         => getenv('PAGE_ACCESS_TOKEN'),
    'authorization_key'    => getenv('AUTHORIZATION_KEY'),
];