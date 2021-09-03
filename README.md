# OpenApiValidatorModule

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)

This module relies on [thephpleague/openapi-psr7-validator](https://github.com/thephpleague/openapi-psr7-validator) for validating http responses and requests against 
an [OpenApi 3.0 (or swagger)](https://swagger.io/specification/) specification.

## Install

Via Composer

``` bash
$ composer require bajuju67/open-api-validator-module
```

## Usage
Enable the module by adding the following line under `enabled` section in the test suite yml file:

``` php
enabled:
    - OpenApiValidator
```

Make sure to also add the right config under `config` in the test suite yml file:

```php
config:
    OpenApiValidator:
        host: 'https://example.com'
        content: 'application/json'
        contentType: 'application/json'
        username: '<username>'
        password: '<password>'
 ```

Add `username` and `password` if there is any basic http authentication enabled.

Run `codecept build` to rebuild the Actor class with the new functions from the Module.

Now in your test files you have access to two new functions:

``` php
sendRequest(string $method, string $path, array $params)
validateResponse(string $path, string $method, ResponseInterface $response)
```
example:
``` php
$response = $I->sendRequest('post', '/api/resource', ['json' => [...]]);
$I->validate('post', '/api/resource', $response);
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email bajuju67@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/bajuju67/open-api-validator-module.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/bajuju67/open-api-validator-module/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/bajuju67/open-api-validator-module.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/bajuju67/open-api-validator-module.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/bajuju67/open-api-validator-module.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/bajuju67/open-api-validator-module
[link-travis]: https://travis-ci.org/bajuju67/open-api-validator-module
[link-scrutinizer]: https://scrutinizer-ci.com/g/bajuju67/open-api-validator-module/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/bajuju67/open-api-validator-module
[link-downloads]: https://packagist.org/packages/bajuju67/open-api-validator-module
[link-author]: https://github.com/bajuju67
[link-contributors]: ../../contributors
