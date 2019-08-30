<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    protected function getInstancesFromContainer($class)
    {
        $reflection = new \ReflectionClass($class);

        $instances = $reflection->getProperty('instances');
        $instances->setAccessible(true);

        return $instances->getValue($class);
    }
}
