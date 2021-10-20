<?php

use app\Controller\UsersController;

return [
    "singleton" => [
        UsersController::class, UsersController::class
    ]
];
