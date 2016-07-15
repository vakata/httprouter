<?php

namespace vakata\httprouter;

use vakata\http\RequestInterface;

interface MiddlewareInterface
{
    public function handle(RequestInterface $request, callable $next, array $segments = []);
}
