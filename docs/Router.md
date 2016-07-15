# vakata\httprouter\Router
An extended implementation of the routing class, dealing with an HTTP abstraction and middleware.

## Methods

| Name | Description |
|------|-------------|
|[middleware](#vakata\httprouter\routermiddleware)|Add a middleware layer|
|[runRequest](#vakata\httprouter\routerrunrequest)|Runs the router with the specified input, invokes the registered callbacks (passing through all middle layers)|
|[setBase](#vakata\httprouter\routersetbase)|Set the router base (string that will be stripped if found at the beggining of the URL when running the router)|
|[detectBase](#vakata\httprouter\routerdetectbase)|Auteodetects the router's base (string that will be stripped if found at the beggining of any processed URL)|
|[getBase](#vakata\httprouter\routergetbase)|return the base part of the URL (that is not evaluated by the router)|
|[getPrefix](#vakata\httprouter\routergetprefix)|Get the current prefix|
|[setPrefix](#vakata\httprouter\routersetprefix)|Set the prefix for all future URLs, used mainly internally.|
|[group](#vakata\httprouter\routergroup)|Group a few routes together (when sharing a common prefix)|
|[add](#vakata\httprouter\routeradd)|Add a route. All params are optional and each of them can be omitted independently.|
|[get](#vakata\httprouter\routerget)|Shortcut for add('GET', $url, $handler)|
|[report](#vakata\httprouter\routerreport)|Shortcut for add('REPORT', $url, $handler)|
|[post](#vakata\httprouter\routerpost)|Shortcut for add('POST', $url, $handler)|
|[head](#vakata\httprouter\routerhead)|Shortcut for add('HEAD', $url, $handler)|
|[put](#vakata\httprouter\routerput)|Shortcut for add('PUT', $url, $handler)|
|[patch](#vakata\httprouter\routerpatch)|Shortcut for add('PATCH', $url, $handler)|
|[delete](#vakata\httprouter\routerdelete)|Shortcut for add('DELETE', $url, $handler)|
|[options](#vakata\httprouter\routeroptions)|Shortcut for add('OPTIONS', $url, $handler)|
|[run](#vakata\httprouter\routerrun)|Runs the router with the specified input, invokes the registered callbacks (if a match is found)|

---



### vakata\httprouter\Router::middleware
Add a middleware layer  


```php
public function middleware (  
    \HttpMiddlewareInterface $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$handler` | `\HttpMiddlewareInterface` | receives the request and a callable for next layer. |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::runRequest
Runs the router with the specified input, invokes the registered callbacks (passing through all middle layers)  


```php
public function runRequest (  
    \RequestInterface $req  
) : \ResponseInterface    
```

|  | Type | Description |
|-----|-----|-----|
| `$req` | `\RequestInterface` | the HTTP request |
|  |  |  |
| `return` | `\ResponseInterface` | the populated HTTP response |

---


### vakata\httprouter\Router::setBase
Set the router base (string that will be stripped if found at the beggining of the URL when running the router)  


```php
public function setBase (  
    string $base  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$base` | `string` | the string to strip |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::detectBase
Auteodetects the router's base (string that will be stripped if found at the beggining of any processed URL)  


```php
public function detectBase () : self    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::getBase
return the base part of the URL (that is not evaluated by the router)  


```php
public function getBase () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | the base URL |

---


### vakata\httprouter\Router::getPrefix
Get the current prefix  


```php
public function getPrefix () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | $prefix the prefix |

---


### vakata\httprouter\Router::setPrefix
Set the prefix for all future URLs, used mainly internally.  


```php
public function setPrefix (  
    string $prefix  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$prefix` | `string` | the prefix to prepend |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::group
Group a few routes together (when sharing a common prefix)  


```php
public function group (  
    string $prefix,  
    callable $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$prefix` | `string` | the common prefix |
| `$handler` | `callable` | a function to add the actual routes from, receives the router object as parameter |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::add
Add a route. All params are optional and each of them can be omitted independently.  


```php
public function add (  
    array|string $method,  
    string $url,  
    callable $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$method` | `array`, `string` | HTTP verbs for which this route is valid |
| `$url` | `string` | the route URL (check the usage docs for information on supported formats) |
| `$handler` | `callable` | the handler to execute when the route is matched |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::get
Shortcut for add('GET', $url, $handler)  


```php
public function get (  
    string $url,  
    callable $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$url` | `string` |  |
| `$handler` | `callable` |  |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::report
Shortcut for add('REPORT', $url, $handler)  


```php
public function report (  
    string $url,  
    callable $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$url` | `string` |  |
| `$handler` | `callable` |  |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::post
Shortcut for add('POST', $url, $handler)  


```php
public function post (  
    string $url,  
    callable $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$url` | `string` |  |
| `$handler` | `callable` |  |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::head
Shortcut for add('HEAD', $url, $handler)  


```php
public function head (  
    string $url,  
    callable $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$url` | `string` |  |
| `$handler` | `callable` |  |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::put
Shortcut for add('PUT', $url, $handler)  


```php
public function put (  
    string $url,  
    callable $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$url` | `string` |  |
| `$handler` | `callable` |  |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::patch
Shortcut for add('PATCH', $url, $handler)  


```php
public function patch (  
    string $url,  
    callable $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$url` | `string` |  |
| `$handler` | `callable` |  |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::delete
Shortcut for add('DELETE', $url, $handler)  


```php
public function delete (  
    string $url,  
    callable $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$url` | `string` |  |
| `$handler` | `callable` |  |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::options
Shortcut for add('OPTIONS', $url, $handler)  


```php
public function options (  
    string $url,  
    callable $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$url` | `string` |  |
| `$handler` | `callable` |  |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\Router::run
Runs the router with the specified input, invokes the registered callbacks (if a match is found)  


```php
public function run (  
    string $request,  
    string $verb  
) : mixed    
```

|  | Type | Description |
|-----|-----|-----|
| `$request` | `string` | the path to check |
| `$verb` | `string` | the HTTP verb to check (defaults to GET) |
|  |  |  |
| `return` | `mixed` | if a match is found the result of the callback is returned |

---

