<?php

namespace vakata\httprouter;

use vakata\http\RequestInterface;

interface HttpMiddlewareInterface
{
    public function handle(RequestInterface $request, callable $next, HttpRouter $rtr = null);
}
