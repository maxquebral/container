<?php
/**
 * Author: MaxQuebral
 * Date: 9/4/17
 * Project: Container
 * Filename: TestCase.php
 */

namespace Tests;

use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
{
    protected function getInstancesFromContainer($class)
    {
        $reflection = new \ReflectionClass($class);

        $instances = $reflection->getProperty('instances');
        $instances->setAccessible(true);

        return $instances->getValue($class);
    }
}
