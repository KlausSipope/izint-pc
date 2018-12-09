<?php declare(strict_types=1);

namespace App\Tests;

use ReflectionClass;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
trait PropertyAccessTrait
{
    /**
     * @param $entity
     * @param $value
     * @param string $propertyName
     *
     * @throws \ReflectionException
     */
    public function setProperty($entity, $value, string $propertyName)
    {
        $class = new ReflectionClass($entity);

        $property = $class->getProperty($propertyName);
        $property->setAccessible(true);

        $property->setValue($entity, $value);
    }
}
