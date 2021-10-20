<?php

use Illuminate\Container\Container;
use Core\Router\Router;
use Illuminate\Contracts\Events\Dispatcher as EventsContract;
use Illuminate\Events\Dispatcher as EventsDispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

error_reporting( E_ALL | E_STRICT);

$app = new Container();

$app->instance('App', $app);
$app->instance(Container::class, $app);
$app->instance('\Illuminate\Contracts\Container\Container', $app);
$app->singleton(EventsContract::class, EventsDispatcher::class);
$app->singleton("events", EventsDispatcher::class);

$app->singleton('config', Core\Setting\Setting::class);

$app->singleton('request', Core\Request\Request::class);
$app->singleton(Core\Request\IRequest::class, Core\Request\Request::class);

$app->singleton('dispatcher', Core\Dispatch\Dispatch::class);

$app->singleton('response', Core\Response\Response::class);
$app->singleton(Core\Response\IResponse::class, Core\Response\Response::class);

/**
 * Load App dependencies
 */

$services =  require_once(APP_DIR . 'services.php');

foreach ($services as $kind => $abstractAndImplementation) {
    call_user_func_array([$app, $kind], $abstractAndImplementation);
}

/**
 * Load routes
 */
$router  = new Router($app->request);

$routesGroup  = require_once(APP_DIR . 'routes.php');
foreach ($routesGroup as $method => $routes) {
    foreach ($routes as $url => $handler) {
        $router->add($url, $method, $handler);
    }
}

$router->error(function () use ($app){
    return $app->make('response', [
        "status" => 404,
        "data" => [
            "error" => "404"
        ]
    ]);
});



$app->instance('router', $router);
$app->instance(Core\Router\Router::class, $router);

/**
 * Connect to DB
 */
$capsule = new Capsule($app);
$capsule->addConnection($app['config']['database.connections'][DB_DRIVER]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

//dispatch controller
$app->dispatcher->dispatch();
