<?php
namespace Core\Router;

use Core\Request\IRequest;

/**
 * Router class will load requested Controller / closure based on url.
 */
class Router
{
    /**
     * Base url of site
     */
    private string $basePath = '';
    /**
     * Array of routes
     *
     */
    protected array $routes = [];
    /**
     * Array of methods
     *
     * @var array $methods
     */
    protected array $methods = ['GET', 'POST', 'DELETE', 'PUT'];

    /**
     * Array of callbacks
     *
     * @var array $callbacks
     */
    protected array $callbacks = [];

    /**
     * Set an error callback
     *
     * @var string|callable|null $errorCallback
     */
    private $errorCallback;

    /**
     * @var IRequest
     */
    private IRequest $request;

    private string $currentRoute;
    private ?array $currentVars;

    /** Set route patterns */
    protected array $patterns = [
        ':any' => '[^/]+',
        ':id' => '(?!new)[^/]+',
        ':num' => '-?[0-9]+',
        ':all' => '.*',
        ':hex' => '[[:xdigit:]]+',
        ':uuidV4' => '\w{8}-\w{4}-\w{4}-\w{4}-\w{12}'
    ];


    public function __construct(IRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $uri
     * @return string
     */
    protected function normalizeUri(string $uri): string
    {
        return $this->basePath . (!empty($uri) ? '/' . $uri : '');
    }

    private function normalizeCallback($callback)
    {
        return is_callable($callback) ? $callback : str_replace('/', '\\', $callback);
    }

    public function add(string $uri, string $method, $callback): Router
    {
        $this->routes[] = $this->normalizeUri($uri);
        $this->callbacks[] = [$method => $this->normalizeCallback($callback)];
        return $this;
    }

    public function get(string $uri, $callback): Router
    {
        $this->add($uri, 'GET', $callback);
        return $this;
    }

    public function post(string $uri, $callback): Router
    {
        $this->add($uri, 'POST', $callback);
        return $this;
    }

    public function delete(string $uri, $callback): Router
    {
        $this->add($uri, 'DELETE', $callback);
        return $this;
    }

    public function put(string $uri, $callback): Router
    {
        $this->add($uri, 'PUT', $callback);
        return $this;
    }

    public function match(string $uri, $callback, array $includes = []): Router
    {
        if (!empty($includes)) {
            foreach ($includes as &$include) {
                $this->add($uri, $include, $callback);
            }
        }
        return $this;
    }

    public function any(string $uri, $callback): Router
    {
        foreach ($this->methods as &$include) {
            $this->add($uri, $include, $callback);
        }
        return $this;
    }

    /**
     * Defines callback if route is not found.
     * @param callable|string $callback
     * @return Router
     */
    public function error($callback): Router
    {
        $this->errorCallback = $callback;
        return $this;
    }

    private $callback = null;
    private $vars = null;

    /**
     * Defines callback if route is not found.
     * @param callable|string $callback
     * @return Router
     */
    public function setCallback($callback): Router
    {
        $this->callback = $callback;
        return $this;
    }

    public function setVars(array $vars = []): Router
    {
        $this->vars = $vars;
        return $this;
    }

    private function getHandlerDetail($callback, $matched = [])
    {
        $callback = is_null($this->callback) ? $callback : $this->callback;
        $matched = is_null($this->vars) ? $matched : $this->vars;

        if ($callback instanceof \Closure) {
            return ['function' => $callback, 'vars' => $matched];
        }

        if (is_callable($callback)) {
            return [
                'Controller' => $callback[0],
                'method' => $callback[1],
                'vars' => $matched
            ];
        }

        $last = explode('/', $callback);
        $last = end($last);

        $segments = explode('@', $last);

        $controller = $segments[0];
        $method = $segments[1];
        return [
            'Controller' => $controller,
            'method' => $method,
            'vars' => $matched,
        ];
    }

    /**
     * Get the callback for the given request.
     */
    public function getHandlerData()
    {
        $uri = $this->request->getUri();
        $method = $this->request->getMethod();
        $searches = array_keys($this->patterns);
        $replaces = array_values($this->patterns);

        $this->routes = str_replace('//', '/', $this->routes);

        $routes = $this->routes;
        foreach ($routes as $pos => $route) {
            $curRoute = str_replace(['//', '\\'], '/', $route);
            if (strpos($curRoute, ':') !== false) {
                $curRoute = str_replace($searches, $replaces, $curRoute);
            }
            if (preg_match('#^' . $curRoute . '$#', $uri, $matched)) {

                if (isset($this->callbacks[$pos][$method])) {
                    //remove $matched[0] as [1] is the first parameter.
                    array_shift($matched);

                    $this->currentRoute = $curRoute;
                    $this->currentVars = $matched;

                    return $this->getHandlerDetail($this->callbacks[$pos][$method], $matched);
                }
            }
        }

        return $this->getHandlerDetail($this->errorCallback, []);
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * Base url of site.
     * <code>
     * $router->setBaseUrl('');
     * </code>
     * @param string $baseUrl
     * @return  Router
     */
    public function setBasePath(string $baseUrl): Router
    {
        $this->basePath = $baseUrl;
        return $this;
    }

    /**
     * @return IRequest
     */
    public function getRequest(): IRequest
    {
        return $this->request;
    }

    /**
     * @param $request
     * @return Router
     */
    public function setRequest(IRequest $request): Router
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrentRoute(): string
    {
        return $this->currentRoute;
    }

    /**
     * @return array
     */
    public function getCurrentVars(): array
    {
        return $this->currentVars;
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

}