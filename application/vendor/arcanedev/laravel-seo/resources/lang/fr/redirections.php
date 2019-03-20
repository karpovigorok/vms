<?php

use Symfony\Component\HttpFoundation\Response;

return [

    'statuses' => [
        Response::HTTP_MOVED_PERMANENTLY    => '[301] Déplacé de manière permanente',
        Response::HTTP_SEE_OTHER            => '[302] Voir autres',
        Response::HTTP_TEMPORARY_REDIRECT   => '[307] Redirection temporaire',
        Response::HTTP_PERMANENTLY_REDIRECT => '[308] Redirection permanente',
    ],

];
