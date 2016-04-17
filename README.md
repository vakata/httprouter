# httprouter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Code Climate][ico-cc]][link-cc]
[![Tests Coverage][ico-cc-coverage]][link-cc]

An extended implementation of the routing class, dealing with an HTTP abstraction and middleware.

## Install

Via Composer

``` bash
$ composer require vakata/httprouter
```

## Usage

``` php
// create an instance
$httprouter = new \vakata\httprouter\HttpRouter();
$httprouter
    ->get('/', function () { echo 'homepage'; })
    ->get('/profile', function () { echo 'user profile'; })
    ->group('/books/', function ($httprouter) { // specify a prefix
        $httprouter
            ->get('read/{i:id}', function ($matches) {
                // this method uses a named placeholder
                // when visiting /books/read/10 matches will contain:
                var_dump($matches); // 0 => books, 1 => read, 2 => 10, id => 10
                // placeholders are wrapped in curly braces {...} and can be: 
                //  - i - an integer
                //  - a - any letter (a-z)
                //  - h - any letter or integer
                //  - * - anything (up to the next slash (/))
                //  - ** - anything (to the end of the URL)

                // placeholders can be named too by using the syntax:
                // {placeholder:name}
                
                // placeholders can also be optional
                // {?optional}
            })
            // for advanced users - you can use any regex as a placeholder:
            ->get('{(delete|update):action}/{(\d+):id}', function ($matches) { })
            // you can also use any HTTP verb
            ->post('delete/{i:id}', function ($matches) { })
    })
    // you can also bind multiple HTTP verbs in one go
    ->add(['GET', 'HEAD'], '/path', function () { });

// there is no need to chain the method calls - this works too:
$httprouter->post('123', function () { });
$httprouter->post('456', function () { });

// you finally run the httprouter
try {
    $httprouter->run(
        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
        $_SERVER['REQUEST_METHOD']
    );
} catch (\vakata\router\RouterNotFoundException $e) {
    // thrown if no matching route is found
}
```

Read more in the [API docs](docs/README.md)

## Testing

``` bash
$ composer test
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email github@vakata.com instead of using the issue tracker.

## Credits

- [vakata][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/vakata/httprouter.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/vakata/httprouter/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/vakata/httprouter.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/vakata/httprouter.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/vakata/httprouter.svg?style=flat-square
[ico-cc]: https://img.shields.io/codeclimate/github/vakata/httprouter.svg?style=flat-square
[ico-cc-coverage]: https://img.shields.io/codeclimate/coverage/github/vakata/httprouter.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/vakata/httprouter
[link-travis]: https://travis-ci.org/vakata/httprouter
[link-scrutinizer]: https://scrutinizer-ci.com/g/vakata/httprouter/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/vakata/httprouter
[link-downloads]: https://packagist.org/packages/vakata/httprouter
[link-author]: https://github.com/vakata
[link-contributors]: ../../contributors
[link-cc]: https://codeclimate.com/github/vakata/httprouter

