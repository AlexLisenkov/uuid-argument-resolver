<?php

namespace AlexLisenkov\UuidArgumentResolverBundle\Tests\Dummy;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class DummyHttpResponse extends Response
{
    /**
     * @var Response|null
     */
    private $sent = null;
    /**
     * @var Response
     */
    private $inner;
    /**
     * @var ResponseInterface
     */
    private $psrResponse;

    public function __construct(Response $inner, ResponseInterface $psrResponse)
    {
        $this->inner = $inner;
        $this->psrResponse = $psrResponse;
    }

    public function send(): void
    {
        $this->sent = clone $this->inner;
    }

    public function getSent(): Response
    {
        return $this->sent;
    }

    public function getPsrResponse(): ResponseInterface
    {
        return $this->psrResponse;
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->inner, $name)) {
            return parent::$name(...$arguments);
        }
    }
}
