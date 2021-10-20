<?php
namespace unit\core\library\router;

use Core\Request\IRequest;
use Core\Router\Router;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $request;
    /**
     * @var Router
     */
    private $router;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = $this->getMockForAbstractClass(IRequest::class, [], 'Request',
            false, false, true, ['getExt', 'getUri', 'getMethod']);
        $this->router = new Router($this->request);
        $this->router->error('testError@test');
    }


    public function testChainStyle()
    {
        $this->assertInstanceOf(Router::class, $this->router->setBasePath('/'));
        $this->assertInstanceOf(Router::class, $this->router->add('/test/', 'GET', 'testAction'));
        $this->assertInstanceOf(Router::class, $this->router->get('/test/', 'testAction'));
        $this->assertInstanceOf(Router::class, $this->router->post('/test/', 'testAction'));
        $this->assertInstanceOf(Router::class, $this->router->put('/test/', 'testAction'));
        $this->assertInstanceOf(Router::class, $this->router->delete('/test/', 'testAction'));
        $this->assertInstanceOf(Router::class, $this->router->match('/test/', 'testAction', ['get', 'post']));
        $this->assertInstanceOf(Router::class, $this->router->any('/test/', 'testAction'));
        $this->assertInstanceOf(Router::class, $this->router->error(function () {
        }));
        $this->assertInstanceOf(Router::class, $this->router->setRequest($this->request));
    }

    public function testGetRequest()
    {
        $this->assertInstanceOf(IRequest::class, $this->router->getRequest());
    }
    
    /**
     * @dataProvider routeProvider
     */
    public function testGetMethodRoute($uri, $route, $handler, $handlerData)
    {
        $this->request->expects($this->once())->method('getUri')->will($this->returnValue($uri));
        $this->request->expects($this->once())->method('getMethod')->will($this->returnValue('GET'));

        $this->router->get($route, $handler);
        $this->assertEquals($handlerData, $this->router->getHandlerData());

    }

    /**
     * @dataProvider routeProvider
     */
    public function testPostHttpMethodRoute($uri, $route, $handler, $handlerData)
    {
        $this->request->expects($this->once())->method('getUri')->will($this->returnValue($uri));
        $this->request->expects($this->once())->method('getMethod')->will($this->returnValue('POST'));

        $this->router->post($route, $handler);
        $this->assertEquals($handlerData, $this->router->getHandlerData());
    }

    /**
     * @dataProvider routeProvider
     */
    public function testPutHttpMethodRoute($uri, $route, $handler, $handlerData)
    {
        $this->request->expects($this->once())->method('getUri')->will($this->returnValue($uri));
        $this->request->expects($this->once())->method('getMethod')->will($this->returnValue('PUT'));

        $this->router->put($route, $handler);
        $this->assertEquals($handlerData, $this->router->getHandlerData());
    }

    /**
     * @dataProvider routeProvider
     */
    public function testDeleteHttpMethodRoute($uri, $route, $handler, $handlerData)
    {
        $this->request->expects($this->once())->method('getUri')->will($this->returnValue($uri));
        $this->request->expects($this->once())->method('getMethod')->will($this->returnValue('DELETE'));

        $this->router->delete($route, $handler);
        $this->assertEquals($handlerData, $this->router->getHandlerData());
    }

    public function routeProvider()
    {
        return [
            ['/test', '/test', 'testCtrl1@test', ['Controller' => 'testCtrl1', 'method' => 'test', 'vars' => []]],
            ['/test/uri', '/test/uri', 'testCtrl2@test2', ['Controller' => 'testCtrl2', 'method' => 'test2', 'vars' => []]],
            ['/func', 'func', function () {}, ['function' => function () {}, 'vars' => []]],
            ['/user/1', 'user/(:num)', function () {}, ['function' => function () {}, 'vars' => [1]]],
            ['/user/1/2', 'user/(:num)/(:num)', function () {}, ['function' => function () {}, 'vars' => [1, 2]]],
            ['/user/any_string', 'user/(:any)', function () {}, ['function' => function () {}, 'vars' => ['any_string']]],
            ['/api/any_string/1', '/api/(:all)', function () {}, ['function' => function () {}, 'vars' => ['any_string/1']]],
        ];
    }

    public function testErrorHandler()
    {
        $this->request->expects($this->once())
            ->method('getUri')
            ->will($this->returnValue('/test'));

        $this->request->expects($this->once())
            ->method('getMethod')
            ->will($this->returnValue('GET'));

        $this->router->get('', 'TestController@testAction')
            ->error('testError@test');

        $aActual = $this->router->getHandlerData();

        $this->assertEquals([
            'Controller' => 'testError',
            'method' => 'test',
            'vars' => [],
        ], $aActual);

    }

    /**
     * @dataProvider curRouteAndVarsProvider
     */
    public function testGetCurrentRouteAndVars($realUri, $uri, $callback, $vars)
    {
        $this->request->expects($this->once())->method('getUri')->will($this->returnValue($realUri));
        $this->request->expects($this->once())->method('getMethod')->will($this->returnValue('GET'));
        $this->router->get($uri, $callback);
        $this->router->getHandlerData();
        $this->assertEquals($uri, $this->router->getCurrentRoute());
        $this->assertEquals($vars, $this->router->getCurrentVars());
    }

    public function curRouteAndVarsProvider()
    {
        return [
            ['/test', '/test', 'test/Controller@index', []],
            ['/test/1', '/test/(:num)', 'test/Controller@index', [1]],
            ['/test/any', '/test/(:any)', 'test/Controller@index', ['any']],
        ];
    }
}