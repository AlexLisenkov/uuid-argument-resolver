<?php

namespace AlexLisenkov\UuidArgumentResolverBundle;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class InvalidUuidResponseFactory
{
    public static function create(): ResponseInterface
    {
        return new Response(\Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST, [], 'Invalid UUID');
    }
}
