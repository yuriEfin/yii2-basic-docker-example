<?php

declare(strict_types=1);

return [
    'adminEmail'  => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName'  => 'Example.com mailer',
    'jwt'         => [
        'issuer'   => 'http://web-auth.work:8081/api',  // name of your project (for information only)
        'key'      => 'mrHDXedN92g4dbderWgSFm5KzOTcOP1Ls6cL4Og2mfw',
        'audience' => 'https://frontend.example.com',       // description of the audience, eg. the website using the authentication (for info only)
        'id'       => 'a8f5f167f44f4964e6c998dee827110c',   // a unique identifier for the JWT, typically a random string
        'expire'   => 3600,                                 // the short-lived JWT token is here set to expire after 5 min.
    ],
];
