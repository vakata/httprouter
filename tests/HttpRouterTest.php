<?php
namespace vakata\httprouter\test;

class HttpRouterTest extends \PHPUnit_Framework_TestCase
{
	protected static $router = null;
	protected static $res = null;

	public static function setUpBeforeClass() {
	}
	public static function tearDownAfterClass() {
	}
	protected function setUp() {
	}
	protected function tearDown() {
	}

	public function testCreate() {
		self::$res = new \vakata\http\Response();
		self::$router = new \vakata\httprouter\HttpRouter();
		$this->assertEquals(true, self::$router->isEmpty());
		self::$router
			->get('/get', function () { return 1; })
			->get('/get', function () { return 2; })
			->post('post', function () { return 3; })
			->report('report', function () { return 4; })
			->options('options', function () { return 5; })
			->put('put', function () { return 6; })
			->patch('patch', function () { return 7; })
			->add('DELETE', function () { return 8; })
			->head('head', function () { return 9; })
			->add(['GET','POST'], '/mixed', function () { return 10; })
			->get('/nested/path', function () { return 11; })
			->get('/named/{*:named}', function ($arg) { return $arg['named']; })
			->get('/types/{i}', function ($arg) { return $arg[1]; })
			->get('/types/{a}', function ($arg) { return $arg[1]; })
			->get('/types/{h}', function ($arg) { return $arg[1]; })
			->get('/types/{*}', function ($arg) { return $arg[1]; })
			->get('/types/{**}', function ($arg) { return $arg[2]; })
			->get('/optional/{?i}', function ($arg) { return isset($arg[1]) ? $arg[1] : ''; })
			->get('regex/{(asdf|zxcv)}', function () { return 14; });
		$this->assertEquals(false, self::$router->isEmpty());
	}
	/**
	 * @depends testCreate
	 */
	public function testRoutes() {
		$this->assertEquals(2, self::$router->run(new \vakata\http\Request('GET', 'get'))->getBody(true));
		$this->assertEquals(3, self::$router->run(new \vakata\http\Request('POST', 'post'))->getBody(true));
		$this->assertEquals(4, self::$router->run(new \vakata\http\Request('REPORT', 'report'))->getBody(true));
		$this->assertEquals(5, self::$router->run(new \vakata\http\Request('OPTIONS', 'options'))->getBody(true));
		$this->assertEquals(6, self::$router->run(new \vakata\http\Request('PUT', 'put'))->getBody(true));
		$this->assertEquals(7, self::$router->run(new \vakata\http\Request('PATCH', 'patch'))->getBody(true));
		$this->assertEquals(8, self::$router->run(new \vakata\http\Request('DELETE', 'delete/something'))->getBody(true));
		$this->assertEquals(9, self::$router->run(new \vakata\http\Request('HEAD', 'head'))->getBody(true));
		$this->assertEquals(10, self::$router->run(new \vakata\http\Request('GET', 'mixed'))->getBody(true));
		$this->assertEquals(10, self::$router->run(new \vakata\http\Request('POST', 'mixed'))->getBody(true));
		$this->assertEquals(11, self::$router->run(new \vakata\http\Request('GET', '/nested/path/'))->getBody(true));
		$this->assertEquals('name1', self::$router->run(new \vakata\http\Request('GET', 'named/name1'))->getBody(true));
		$this->assertEquals('name2', self::$router->run(new \vakata\http\Request('GET', 'named/name2'))->getBody(true));
		$this->assertEquals('1',  self::$router->run(new \vakata\http\Request('GET', 'types/1'))->getBody(true));
		$this->assertEquals('a',  self::$router->run(new \vakata\http\Request('GET', 'types/a'))->getBody(true));
		$this->assertEquals('a0', self::$router->run(new \vakata\http\Request('GET', 'types/a0'))->getBody(true));
		$this->assertEquals('@',  self::$router->run(new \vakata\http\Request('GET', 'types/@'))->getBody(true));
		$this->assertEquals('$',  self::$router->run(new \vakata\http\Request('GET', '/types/@/$/'))->getBody(true));
		$this->assertEquals('',   self::$router->run(new \vakata\http\Request('GET', 'optional'))->getBody(true));
		$this->assertEquals('1',  self::$router->run(new \vakata\http\Request('GET', 'optional/1'))->getBody(true));
		$this->assertEquals(14,   self::$router->run(new \vakata\http\Request('GET', 'regex/asdf'))->getBody(true));
		$this->assertEquals(14,   self::$router->run(new \vakata\http\Request('GET', 'regex/zxcv'))->getBody(true));
	}
	/**
	 * @depends testCreate
	 */
	public function testInvalid() {
		$this->setExpectedException('\vakata\router\RouterException');
		self::$router->run(new \vakata\http\Request('GET', 'regex/qwer'), self::$res);
	}
	public function testBase() {
		$router1 = new \vakata\httprouter\HttpRouter('/asdf/');
		$router2 = new \vakata\httprouter\HttpRouter();
		$router1->get('test', function () { return 1; });
		$router2->get('test', function () { return 1; });
		$this->assertEquals(1, $router1->run(new \vakata\http\Request('GET', 'asdf/test'))->getBody(true));
		try {
			$router2->run(new \vakata\http\Request('GET', 'asdf/test'));
			$this->assertEquals(true, false);
		} catch (\vakata\router\RouterException $e) {
			$this->assertEquals(true, true);
		}
	}
	public function testGroup() {
		$router = new \vakata\httprouter\HttpRouter();
		$router->group('prefix', function ($router) {
			$router->get('a', function () { return 1; });
		});
		$this->assertEquals(1, $router->run(new \vakata\http\Request('GET', 'prefix/a'))->getBody(true));

		$router1 = new \vakata\httprouter\HttpRouter();
		$router1->group('prefix', function () use ($router1) {
			$router1->get('b', function () { return 1; });
		});
		$this->assertEquals(1, $router1->run(new \vakata\http\Request('GET', 'prefix/b'))->getBody(true));

		$this->setExpectedException('\vakata\router\RouterException');
		$router1->run(new \vakata\http\Request('GET', 'prefix/a'));
	}
	public function testHelpers() {
		$router = new \vakata\httprouter\HttpRouter();
		$this->assertEquals([1, 2, 3], $router->segments('1/2/3'));
		$this->assertEquals(3, $router->segment(-1, '1/2/3'));
		$this->assertEquals(1, $router->segment(0, '1/2/3'));
	}
}
