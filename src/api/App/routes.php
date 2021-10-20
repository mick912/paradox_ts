<?php

use App\Controller\UsersController;

return [
    'GET' => [
        "/users/" => [UsersController::class, 'index'],
        "/users/(:num)/" => [UsersController::class, 'retrieve']
    ]
];