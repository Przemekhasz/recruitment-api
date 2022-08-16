<?php

declare(strict_types=1);

namespace App\kernel\sharedKernel\helper\JSONApi\handler;

class CircularReferenceHandler
{
    public function __invoke($object)
    {
        return $object->getId();
    }
}
