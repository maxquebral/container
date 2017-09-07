<?php
/**
 * Author: MaxQuebral
 * Date: 9/4/17
 * Project: Container
 * Filename: ContainerTeset.php
 */

namespace Tests\Framework;


use MaxQuebral\Framework\Container;
use Tests\Mocks\ClassA;
use Tests\Mocks\ClassB;
use Tests\Mocks\ClassC;
use Tests\Mocks\ClassD;
use Tests\Mocks\InterfaceA;
use Tests\TestCase;

class ContainerTest extends TestCase
{
    /** @var $container Container */
    private $container;

    public function setUp()
    {
        $this->container = new Container();
    }

    public function testShouldBindObjectAndGetInstanceFromTheContainer()
    {
        $this->container->bind(InterfaceA::class, ClassA::class);

        $classA = $this->container->getInstance(InterfaceA::class);

        $this->assertInstanceOf(ClassA::class, $classA);
    }

    public function testShouldBindObjectUsingAClosure()
    {
        $classD = $this->container->bind('test', function () {
            return new ClassD();
        });

        $this->assertInstanceOf(ClassD::class, $classD);
    }

    public function testShouldMakeObject()
    {
        $res = $this->container->make(ClassC::class);

        $this->assertInstanceOf(ClassC::class, $res);
    }

    public function testShouldMakeObjectWithoutConstructor()
    {
        $res = $this->container->make(ClassD::class);

        $this->assertInstanceOf(ClassD::class, $res);
    }

    public function testShouldMakeObjectUsingClosure()
    {
        $res = $this->container->make(function () {
            return ClassC::class;
        });

        $this->assertInstanceOf(ClassC::class, $res);
    }
}
