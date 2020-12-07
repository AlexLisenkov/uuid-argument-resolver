<?php

namespace AlexLisenkov\UuidArgumentResolverBundle\Tests;

use AlexLisenkov\UuidArgumentResolverBundle\InvalidUuidResponseFactory;
use AlexLisenkov\UuidArgumentResolverBundle\Resolver;
use AlexLisenkov\UuidArgumentResolverBundle\Tests\Dummy\DummyHttpFoundationFactory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ResolverTest extends TestCase
{
    public function testSupports_willNotSupportStringType(): void
    {
        $subject = new Resolver(new HttpFoundationFactory(), new Response());

        $request = new Request();
        $argument = new ArgumentMetadata('uuid', 'string', false, false, null);

        $result = $subject->supports($request, $argument);

        self::assertFalse($result);
    }

    public function testSupports_willSupportValidUuid(): void
    {
        $subject = new Resolver(new HttpFoundationFactory(), new Response());

        $request = new Request([], [], ['uuid' => '00000000-0000-0000-0000-000000000000']);
        $argument = new ArgumentMetadata('uuid', UuidInterface::class, false, false, null);

        $result = $subject->supports($request, $argument);

        self::assertTrue($result);
    }

    public function testSupports_willSendResponse(): void
    {
        $httpResponseFactory = new DummyHttpFoundationFactory();
        $response = InvalidUuidResponseFactory::create();
        $subject = new Resolver($httpResponseFactory, $response);

        $request = new Request([], [], ['uuid' => 'invalid']);
        $argument = new ArgumentMetadata('uuid', UuidInterface::class, false, false, null);

        $result = $subject->supports($request, $argument);
        $actualResponse = $httpResponseFactory->getResponses()[0]->getPsrResponse();

        self::assertFalse($result);
        self::assertSame($response, $actualResponse);
    }

    public function testResolve(): void
    {
        $subject = new Resolver(new HttpFoundationFactory(), new Response());

        $request = new Request([], [], ['uuid' => '00000000-0000-0000-0000-000000000000']);
        $argument = new ArgumentMetadata('uuid', UuidInterface::class, false, false, null);

        $result = $subject->resolve($request, $argument);

        self::assertEquals(Uuid::fromString('00000000-0000-0000-0000-000000000000'), $result->current());
    }
}
