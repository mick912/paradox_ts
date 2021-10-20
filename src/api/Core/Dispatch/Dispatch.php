<?php
namespace Core\Dispatch;

use Core\Response\IResponse;
use Core\Router\Router;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;

class Dispatch implements IDispatch
{

    private Container $container;

    /**
     * FrontController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * dispatching Controller
     * @return void
     * @throws BindingResolutionException
     */
    public function dispatch()
    {
        $handler = $this->container->router->getHandlerData();
        $dispatchMethod = array_key_exists('function', $handler) ? 'dispatchFunction': 'dispatchController';
        $response = call_user_func([$this, $dispatchMethod], $handler);
        http_response_code($response->getStatus());
        echo $response->render();
    }

    protected function dispatchFunction(array $handler): IResponse
    {
        return call_user_func_array($handler['function'], $handler['vars']);
    }

    protected function dispatchController(array $handler): IResponse
    {
        $controller = $this->container->make($handler['Controller']);
        return call_user_func_array([$controller, $handler['method']], $handler['vars']);
    }
}