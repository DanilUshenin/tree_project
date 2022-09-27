<?php

return array(

    '/create_node' => [
        'http_method' => 'post',
        'controller' => \Controllers\HomePageController::class,
        'action' => 'createNode'
    ],

    '/delete_node' => [
        'http_method' => 'post',
        'controller' => \Controllers\HomePageController::class,
        'action' => 'deleteNode'
    ],

    '/rename_node' => [
        'http_method' => 'post',
        'controller' => \Controllers\HomePageController::class,
        'action' => 'renameNode'
    ],

    '/' => [
        'http_method' => 'get',
        'controller' => \Controllers\HomePageController::class,
        'action' => 'view'
    ],

);