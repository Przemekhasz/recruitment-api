<?php

declare(strict_types=1);

namespace App\kernel\sharedKernel\helper\DTOHelper;

use ArrayObject;
use Exception;
use ReflectionClass;
use ReflectionProperty;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;

class DTOHelper
{
    /**
     * @param $json
     * @param $dto
     * @return void
     */
    public function assignJsonToProperties(&$dto, $json): void
    {
        if ($json instanceof Request) {
            $json = $json->getContent();
        }

        if ($json instanceof InputBag) {
            $json = $json->all();
        }
        if (is_string($json)) {
            $json = (array)json_decode($json);
        }

        if (!is_array($json)) {
            $json = [];
        }

        foreach ($json as $k=>$v) {
//            if (is_array($v)) {
//                $v = implode(', ', $v);
//            }

            $property = &$dto->{$k};
            $value = $v;

            $property = $value;
        }
    }

    /**
     * @param ArrayObject $dto
     * @param  $class
     * @return ArrayObject
     * @throws \ReflectionException
     */
    public static function assignArrayToDTO(ArrayObject &$dto, $class): ArrayObject
    {
        $reflect = (new ReflectionClass($class));


        foreach ($reflect->getProperties(ReflectionProperty::IS_PRIVATE) as $property) {
           try {
               $methodName = 'get'.ucfirst($property->getName());
               if (!$reflect->hasMethod($methodName)) continue;
               $k = $property->getName();
               $v = $class->{$methodName}();
               $dto[$k] = $v;
           }
           catch (Exception $exception) {
               continue;
           }
        }

        foreach ($reflect->getTraits() as $trait) {

            foreach ($trait->getProperties() as $property) {
                $methodName = 'get'.ucfirst($property->getName());
                if (!$reflect->hasMethod($methodName)) continue;
                $k = $property->getName();
                $v = $class->{$methodName}();
                $dto[$k] = $v;
            }

        }
        return $dto;
    }
}
