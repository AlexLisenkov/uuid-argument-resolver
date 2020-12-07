<?php

namespace AlexLisenkov\UuidArgumentResolverBundle;

use AlexLisenkov\UuidArgumentResolverBundle\DependencyInjection\UuidArgumentResolverExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class UuidArgumentResolverBundle extends Bundle
{
    public function getContainerExtension(): UuidArgumentResolverExtension
    {
        return new UuidArgumentResolverExtension();
    }
}
