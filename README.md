# UUID Argument Resolver Bundle
ramsey/uuid argument resolver bundle for Symfony

[![Coverage Status](https://coveralls.io/repos/github/AlexLisenkov/uuid-argument-resolver/badge.svg?branch=main)](https://coveralls.io/github/AlexLisenkov/uuid-argument-resolver?branch=main)
![CI](https://github.com/AlexLisenkov/uuid-argument-resolver/workflows/CI/badge.svg)
![Packagist Downloads](https://img.shields.io/packagist/dt/alexlisenkov/uuid-argument-resolver-bundle)
![PHP Versions](https://img.shields.io/badge/PHP-%5E7.3%20%7C%7C%20%5E8.0-blue)

## Install
```shell
composer require alexlisenkov/uuid-argument-resolver-bundle
```

## Usage
```php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\UuidInterface;

class ResourceController
    /**
     * @Route("/{uuid}", name="show_resource", methods="GET")
     */
    public function show(UuidInterface $resourceUuid, ResourceRepository $resourceRepository): ResponseInterface
    {
        $resource = $resourceRepository->findOneByUuid($resourceUuid);

        if ($resource === null) {
            return new ResourceNotFoundResponse();
        }

        return new ResourceResponse($resource);
    }
```

## Handling invalid uuid
By default, it will respond with `400 Bad Request` with body `Invalid UUID`. But you can configure this by creating a service.

### Custom response
Create a factory that creates a `Psr\Http\Message\ResponseInterface`.
```php
namespace App\Factory;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class InvalidUuidResponseFactory
{
    public static function create(): ResponseInterface
    {
        return new Response(400, [], 'Invalid UUID');
    }
}
```
Override the `alexlisenkov.uuid_argument_resolver_bundle.uuid_invalid_response` service with your factory.
```yaml
alexlisenkov.uuid_argument_resolver_bundle.uuid_invalid_response:
    class: '@Psr\Http\Message\ResponseInterface'
    factory: [ 'App\Factory\InvalidUuidResponseFactory', create ]
```
Now an invalid UUID will return your response.

## Testing
```shell
composer test
```

## Contributing
Contributions are welcome.
