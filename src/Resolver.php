<?php

namespace AlexLisenkov\UuidArgumentResolverBundle;

use Generator;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class Resolver implements ArgumentValueResolverInterface
{
    /**
     * @var HttpFoundationFactoryInterface
     */
    private $httpFoundationFactory;
    /**
     * @var ResponseInterface
     */
    private $invalidUuidResponse;

    public function __construct(HttpFoundationFactoryInterface $httpFoundationFactory, ResponseInterface $invalidUuidResponse)
    {
        $this->httpFoundationFactory = $httpFoundationFactory;
        $this->invalidUuidResponse = $invalidUuidResponse;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (UuidInterface::class !== $argument->getType()) {
            return false;
        }

        if (Uuid::isValid($request->attributes->get($argument->getName()))) {
            return true;
        }

        $this->httpFoundationFactory
            ->createResponse($this->invalidUuidResponse)
            ->send();

        return false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        yield Uuid::fromString($request->attributes->get($argument->getName()));
    }
}
