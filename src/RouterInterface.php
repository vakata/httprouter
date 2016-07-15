<?php

namespace vakata\httprouter;

use vakata\router\RouterInterface as BaseRouter;
use vakata\http\RequestInterface;
use vakata\http\ResponseInterface;

interface RouterInterface extends BaseRouter
{
    public function middleware(MiddlewareInterface $handler) : RouterInterface;
    public function runRequest(RequestInterface $req) : ResponseInterface;
}
