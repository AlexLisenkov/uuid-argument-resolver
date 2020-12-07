<?php

namespace AlexLisenkov\UuidArgumentResolverBundle\Tests\Dummy;

use Psr\Http\Message\ResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

class DummyHttpFoundationFactory extends HttpFoundationFactory
{
    /**
     * @var array
     */
    private $responses;

    public function __construct()
    {
        parent::__construct();

        $this->responses = [];
    }

    public function createResponse(ResponseInterface $psrResponse, bool $streamed = false): DummyHttpResponse
    {
        $response = new DummyHttpResponse(parent::createResponse($psrResponse, $streamed), $psrResponse);
        $this->responses[] = $response;

        return $response;
    }

    public function getResponses(): array
    {
        return $this->responses;
    }
}
