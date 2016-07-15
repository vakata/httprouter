<?php

namespace vakata\httprouter;

use vakata\router\Router as BaseRouter;
use vakata\http\RequestInterface;
use vakata\http\ResponseInterface;
use vakata\http\Response;
use vakata\http\Url;

/**
 * An extended implementation of the routing class, dealing with an HTTP abstraction and middleware.
 */
class Router extends BaseRouter implements RouterInterface
{
    protected $stack = [];

    public function __construct()
    {
        $this->stack[] = function (RequestInterface $req) : ResponseInterface {
            try {
                ob_start();
                $res = $this->run($req->getUrl()->getPath(), $req->getMethod());
                if (!($res instanceof ResponseInterface)) {
                    $body = ob_get_contents();
                    $headers = headers_list();
                    $code = http_response_code();
                    @header_remove();

                    $res = (new Response($code ? $code : 200))->setBody(strlen($body) ? $body : (string)$res);
                    foreach ($headers as $header) {
                        $header = array_map('trim', explode(':', $header, 2));
                        $res->setHeader($header[0], $header[1]);
                    }
                }
                ob_end_clean();
            } catch (\Exception $e) {
                ob_end_clean();
                throw $e;
            }

            return $res;
        };
    }
    /**
     * Add a middleware layer
     * @method middleware
     * @param  HttpMiddlewareInterface   $handler receives the request and a callable for next layer.
     * @return self
     */
    public function middleware(MiddlewareInterface $handler) : RouterInterface
    {
        $next = $this->stack[count($this->stack) - 1];
        $prefix = $this->prefix;
        $this->stack[] = function (RequestInterface $req) use ($handler, $next, $prefix) {
            $segments = $this->segments($req->getUrl()->getPath());
            if ($prefix && !preg_match($this->compile($prefix, false), $this->path($req->getUrl()->getPath()))) {
                return call_user_func($next, $req, $segments);
            } else {
                return $handler->handle(
                    $req,
                    function () use ($req, $next) {
                        return call_user_func($next, $req);
                    },
                    $segments
                );
            }
        };
        return $this;
    }

    /**
     * Runs the router with the specified input, invokes the registered callbacks (passing through all middle layers)
     * @method runRequest
     * @param  RequestInterface  $req the HTTP request
     * @return ResponseInterface      the populated HTTP response
     */
    public function runRequest(RequestInterface $req) : ResponseInterface
    {
        return call_user_func($this->stack[count($this->stack) - 1], $req);
    }
}
