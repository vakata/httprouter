<?php

namespace vakata\httprouter;

use vakata\router\Router;
use vakata\http\Request;
use vakata\http\Response;
use vakata\http\Url;

/**
 * An extended implementation of the routing class, dealing with an HTTP abstraction and middleware.
 */
class HttpRouter
{
    protected $stack = [];
    protected $router = null;
    protected $prefix = '';
    protected $current = null;

    /**
     * Create an instance.
     * You can specify the optional base parameter, that will be stripped if found at the begining of any URL.
     * If you set $base to `true` the router will try to autodetect its base.
     * @method __construct
     * @param  string|boolean      $base optional parameter indicating a common part of all the URLs that will be run
     */
    public function __construct($base = '')
    {
        $this->router = new Router($base);

        $this->stack[] = function (Request $req, Response $res) {
            $request = $this->path($req);
            $verb = $req->getMethod();
            return $this->router->run($request, $verb, [ $req, $res ]);
        };
    }

    public function compile($url, $full = true)
    {
        return $this->router->compile($url, $full);
    }
    /**
     * Group a few routes together (when sharing a common prefix)
     * @method group
     * @param  string   $prefix  the common prefix
     * @param  callable $handler a function to add the actual routes from, receives the router object as parameter
     * @return self
     */
    public function group($prefix, callable $handler)
    {
        $this->router->group($prefix, $handler);
        return $this;
    }
    /**
     * Add a route. All params are optional and each of them can be omitted independently.
     * @method add
     * @param  array|string $method  HTTP verbs for which this route is valid
     * @param  string       $url     the route URL (check the usage docs for information on supported formats)
     * @param  callable     $handler the handler to execute when the route is matched
     * @return self
     */
    public function add($method, $url = null, $handler = null)
    {
        $this->router->add($method, $url, $handler);
        return $this;
    }
    /**
     * Shortcut for add('GET', $url, $handler)
     * @method get
     * @param  string   $url
     * @param  callable $handler
     * @return self
     */
    public function get($url, callable $handler)
    {
        $this->router->get($url, $handler);
        return $this;
    }
    /**
     * Shortcut for add('REPORT', $url, $handler)
     * @method report
     * @param  string   $url
     * @param  callable $handler
     * @return self
     */
    public function report($url, callable $handler)
    {
        $this->router->report($url, $handler);
        return $this;
    }
    /**
     * Shortcut for add('POST', $url, $handler)
     * @method post
     * @param  string   $url
     * @param  callable $handler
     * @return self
     */
    public function post($url, callable $handler)
    {
        $this->router->post($url, $handler);
        return $this;
    }
    /**
     * Shortcut for add('HEAD', $url, $handler)
     * @method head
     * @param  string   $url
     * @param  callable $handler
     * @return self
     */
    public function head($url, callable $handler)
    {
        $this->router->head($url, $handler);
        return $this;
    }
    /**
     * Shortcut for add('PUT', $url, $handler)
     * @method put
     * @param  string   $url
     * @param  callable $handler
     * @return self
     */
    public function put($url, callable $handler)
    {
        $this->router->put($url, $handler);
        return $this;
    }
    /**
     * Shortcut for add('PATCH', $url, $handler)
     * @method patch
     * @param  string   $url
     * @param  callable $handler
     * @return self
     */
    public function patch($url, callable $handler)
    {
        $this->router->patch($url, $handler);
        return $this;
    }
    /**
     * Shortcut for add('DELETE', $url, $handler)
     * @method delete
     * @param  string   $url
     * @param  callable $handler
     * @return self
     */
    public function delete($url, callable $handler)
    {
        $this->router->delete($url, $handler);
        return $this;
    }
    /**
     * Shortcut for add('OPTIONS', $url, $handler)
     * @method options
     * @param  string   $url
     * @param  callable $handler
     * @return self
     */
    public function options($url, callable $handler)
    {
        $this->router->options($url, $handler);
        return $this;
    }
    /**
     * Are there any routes registered in the instances
     * @method isEmpty
     * @return boolean `true` if there are no routes registered
     */
    public function isEmpty()
    {
        return $this->router->isEmpty();
    }
    /**
     * return the base part of the URL (that is not evaluated by the router)
     * @method base
     * @return string the base URL
     */
    public function base()
    {
        return $this->router->base();
    }
    /**
     * convert a router-relative path to a server absolute path
     * @method url
     * @param  string $path   the path to convert (defaults to an empty string)
     * @param  array  $params optional GET parameters to append
     * @return string         the server path
     */
    public function url($path = '', $params = [])
    {
        return $this->router->url($path, $params);
    }
    /**
     * check if a URL would be matched by any routes in the router
     * @method exists
     * @param  string $request the URL to check
     * @param  string $method  for which method to check (defaults to "GET")
     * @return boolean         would the URL match if it is ran
     */
    public function exists($request, $method = 'GET')
    {
        return $this->router->exists($request, $method);
    }
    /**
     * Return the path of a given request with the base stripped off.
     * @method path
     * @param  string|Request|Url $request the request path to parse (optional, defaults to the current run, if router was run)
     * @return string          the parsed request path
     */
    public function path($request = null)
    {
        $request = $request ?: $this->current;
        if ($request instanceof Request) {
            $request = $request->getUrl();
        }
        if ($request instanceof Url) {
            $request = $request->getPath();
        }
        return $this->router->path($request);
    }
    /**
     * Get all the relevant segments from a path string.
     * @method segments
     * @param  string|Request|Url   $request the full path (optional, defaults to the current run, if router was run)
     * @return array             the parsed segments
     */
    public function segments($request = null)
    {
        $request = $this->path($request);
        return $this->router->segments($request);
    }
    /**
     * Get a relevant path segment by index.
     * @method segment
     * @param  int     $i       the desired index
     * @param  string|Request|Url  $request a full path (optional, defaults to the current run, if router was run)
     * @return string           the segment at that index or null
     */
    public function segment($i, $request = null)
    {
        $request = $this->path($request);
        return $this->router->segment($i, $request);
    }
    /**
     * Add a middleware layer
     * @method middleware
     * @param  callable   $handler a function receiving the request, response and a callable to invoke the next layer.
     * @return self
     */
    public function middleware(callable $handler)
    {
        $next = $this->stack[count($this->stack) - 1];
        $prefix = $this->prefix;
        $this->stack[] = function (Request $req, Response $res) use ($handler, $next, $prefix) {
            if ($prefix && !preg_match($this->router->compile($prefix, false), $this->path($req))) {
                return call_user_func($next, $req, $res);
            } else {
                return call_user_func(
                    $handler,
                    $req,
                    $res,
                    function ($res) use ($req, $next) {
                        return call_user_func($next, $req, $res);
                    }
                );
            }
        };
        return $this;
    }

    /**
     * Runs the router with the specified input, invokes the registered callbacks (passing through all middle layers)
     * @method run
     * @param  Request  $req the HTTP request
     * @param  Response $res the HTTP response
     * @return Response      the populated HTTP response
     */
    public function run(Request $req, Response $res)
    {
        $this->current = $req;
        return call_user_func($this->stack[count($this->stack) - 1], $req, $res);
    }
}
