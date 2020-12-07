<?php

namespace AlexLisenkov\UuidArgumentResolverBundle\Tests;

use AlexLisenkov\UuidArgumentResolverBundle\DependencyInjection\UuidArgumentResolverExtension;
use AlexLisenkov\UuidArgumentResolverBundle\UuidArgumentResolverBundle;
use PHPUnit\Framework\TestCase;

class UuidArgumentResolverBundleTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        $subject = new UuidArgumentResolverBundle();

        self::assertEquals(new UuidArgumentResolverExtension(), $subject->getContainerExtension());
    }
}
