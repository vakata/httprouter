<?php

namespace vakata\httprouter;

use vakata\http\RequestInterface;

/**
 * A middleware implementation, which takes in a function and registers it as a middleware.
 */
class CallableMiddleware implements MiddlewareInterface
{
    protected $handler = null;
    public function __construct(callable $handler)
    {
        $this->handler = $handler;
    }
    public function handle(RequestInterface $request, callable $next, array $segments = [])
    {
        return call_user_func($this->handler, $request, $next, $segments);
    }
}
