<?php

use Symfony\Component\HttpFoundation\Response;

return [

    'statuses' => [
        Response::HTTP_MOVED_PERMANENTLY    => '[301] Moved Permanently',
        Response::HTTP_SEE_OTHER            => '[302] See Other',
        Response::HTTP_TEMPORARY_REDIRECT   => '[307] Temporary Redirect',
        Response::HTTP_PERMANENTLY_REDIRECT => '[308] Permanent Redirect',
    ],

];
