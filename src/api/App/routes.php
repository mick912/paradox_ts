<?php

use App\Controller\UsersController;

return [
    'GET' => [
        "/api/users/" => [UsersController::class, 'index'],
        "/api/users/(:num)/" => [UsersController::class, 'retrieve']
    ]
];