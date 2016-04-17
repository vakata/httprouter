# vakata\httprouter\HttpRouter
An extended implementation of the routing class, dealing with an HTTP abstraction and middleware.

## Methods

| Name | Description |
|------|-------------|
|[__construct](#vakata\httprouter\httprouter__construct)|Create an instance.|
|[compile](#vakata\httprouter\httproutercompile)|Compile a rouoter formatted string to a regular expression. Used internally.|
|[getPrefix](#vakata\httprouter\httproutergetprefix)|Get the current prefix|
|[setPrefix](#vakata\httprouter\httproutersetprefix)|Set the prefix for all future URLs, used mainly internally.|
|[group](#vakata\httprouter\httproutergroup)|Group a few routes together (when sharing a common prefix)|
|[add](#vakata\httprouter\httprouteradd)|Add a route. All params are optional and each of them can be omitted independently.|
|[get](#vakata\httprouter\httprouterget)|Shortcut for add('GET', $url, $handler)|
|[report](#vakata\httprouter\httprouterreport)|Shortcut for add('REPORT', $url, $handler)|
|[post](#vakata\httprouter\httprouterpost)|Shortcut for add('POST', $url, $handler)|
|[head](#vakata\httprouter\httprouterhead)|Shortcut for add('HEAD', $url, $handler)|
|[put](#vakata\httprouter\httprouterput)|Shortcut for add('PUT', $url, $handler)|
|[patch](#vakata\httprouter\httprouterpatch)|Shortcut for add('PATCH', $url, $handler)|
|[delete](#vakata\httprouter\httprouterdelete)|Shortcut for add('DELETE', $url, $handler)|
|[options](#vakata\httprouter\httprouteroptions)|Shortcut for add('OPTIONS', $url, $handler)|
|[isEmpty](#vakata\httprouter\httprouterisempty)|Are there any routes registered in the instances|
|[base](#vakata\httprouter\httprouterbase)|return the base part of the URL (that is not evaluated by the router)|
|[url](#vakata\httprouter\httprouterurl)|convert a router-relative path to a server absolute path|
|[exists](#vakata\httprouter\httprouterexists)|check if a URL would be matched by any routes in the router|
|[path](#vakata\httprouter\httprouterpath)|Return the path of a given request with the base stripped off.|
|[segments](#vakata\httprouter\httproutersegments)|Get all the relevant segments from a path string.|
|[segment](#vakata\httprouter\httproutersegment)|Get a relevant path segment by index.|
|[middleware](#vakata\httprouter\httproutermiddleware)|Add a middleware layer|
|[run](#vakata\httprouter\httprouterrun)|Runs the router with the specified input, invokes the registered callbacks (passing through all middle layers)|

---



### vakata\httprouter\HttpRouter::__construct
Create an instance.  
You can specify the optional base parameter, that will be stripped if found at the begining of any URL.  
If you set $base to `true` the router will try to autodetect its base.

```php
public function __construct (  
    string|boolean $base  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$base` | `string`, `boolean` | optional parameter indicating a common part of all the URLs that will be run |

---


### vakata\httprouter\HttpRouter::compile
Compile a rouoter formatted string to a regular expression. Used internally.  


```php
public function compile (  
    string $url,  
    boolean $full  
) : string    
```

|  | Type | Description |
|-----|-----|-----|
| `$url` | `string` | the expression to compile |
| `$full` | `boolean` | is the expression full (as opposed to open-ended partial), defaults to `true` |
|  |  |  |
| `return` | `string` | the regex |

---


### vakata\httprouter\HttpRouter::getPrefix
Get the current prefix  


```php
public function getPrefix () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | $prefix the prefix |

---


### vakata\httprouter\HttpRouter::setPrefix
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


### vakata\httprouter\HttpRouter::group
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


### vakata\httprouter\HttpRouter::add
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


### vakata\httprouter\HttpRouter::get
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


### vakata\httprouter\HttpRouter::report
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


### vakata\httprouter\HttpRouter::post
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


### vakata\httprouter\HttpRouter::head
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


### vakata\httprouter\HttpRouter::put
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


### vakata\httprouter\HttpRouter::patch
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


### vakata\httprouter\HttpRouter::delete
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


### vakata\httprouter\HttpRouter::options
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


### vakata\httprouter\HttpRouter::isEmpty
Are there any routes registered in the instances  


```php
public function isEmpty () : boolean    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `boolean` | `true` if there are no routes registered |

---


### vakata\httprouter\HttpRouter::base
return the base part of the URL (that is not evaluated by the router)  


```php
public function base () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | the base URL |

---


### vakata\httprouter\HttpRouter::url
convert a router-relative path to a server absolute path  


```php
public function url (  
    string $path,  
    array $params  
) : string    
```

|  | Type | Description |
|-----|-----|-----|
| `$path` | `string` | the path to convert (defaults to an empty string) |
| `$params` | `array` | optional GET parameters to append |
|  |  |  |
| `return` | `string` | the server path |

---


### vakata\httprouter\HttpRouter::exists
check if a URL would be matched by any routes in the router  


```php
public function exists (  
    string $request,  
    string $method  
) : boolean    
```

|  | Type | Description |
|-----|-----|-----|
| `$request` | `string` | the URL to check |
| `$method` | `string` | for which method to check (defaults to "GET") |
|  |  |  |
| `return` | `boolean` | would the URL match if it is ran |

---


### vakata\httprouter\HttpRouter::path
Return the path of a given request with the base stripped off.  


```php
public function path (  
    string|\Request|\Url $request  
) : string    
```

|  | Type | Description |
|-----|-----|-----|
| `$request` | `string`, `\Request`, `\Url` | the request path to parse (optional, defaults to the current run, if router was run) |
|  |  |  |
| `return` | `string` | the parsed request path |

---


### vakata\httprouter\HttpRouter::segments
Get all the relevant segments from a path string.  


```php
public function segments (  
    string|\Request|\Url $request  
) : array    
```

|  | Type | Description |
|-----|-----|-----|
| `$request` | `string`, `\Request`, `\Url` | the full path (optional, defaults to the current run, if router was run) |
|  |  |  |
| `return` | `array` | the parsed segments |

---


### vakata\httprouter\HttpRouter::segment
Get a relevant path segment by index.  


```php
public function segment (  
    int $i,  
    string|\Request|\Url $request  
) : string    
```

|  | Type | Description |
|-----|-----|-----|
| `$i` | `int` | the desired index |
| `$request` | `string`, `\Request`, `\Url` | a full path (optional, defaults to the current run, if router was run) |
|  |  |  |
| `return` | `string` | the segment at that index or null |

---


### vakata\httprouter\HttpRouter::middleware
Add a middleware layer  


```php
public function middleware (  
    callable $handler  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$handler` | `callable` | a function receiving the request, response and a callable to invoke the next layer. |
|  |  |  |
| `return` | `self` |  |

---


### vakata\httprouter\HttpRouter::run
Runs the router with the specified input, invokes the registered callbacks (passing through all middle layers)  


```php
public function run (  
    \Request $req,  
    \Response $res  
) : \Response    
```

|  | Type | Description |
|-----|-----|-----|
| `$req` | `\Request` | the HTTP request |
| `$res` | `\Response` | the HTTP response |
|  |  |  |
| `return` | `\Response` | the populated HTTP response |

---

