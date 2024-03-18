<?php
$routes = [
    'tg-admin' => 'trongate_administrators/login',
    'trongate-pages' => 'trongate_pages/index',
    'tg-admin/submit_login' => 'trongate_administrators/submit_login',

    // ENTRIES MODULE
    'entry/(:any)' => 'entries/entry/$1',
];
define('CUSTOM_ROUTES', $routes);
