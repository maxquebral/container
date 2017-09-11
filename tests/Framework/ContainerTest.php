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

    /**
     * @test
     * @group bind
    */
    public function ShouldBindObjectAndGetInstanceFromTheContainer()
    {
        $object = $this->container->bind(InterfaceA::class, ClassA::class);
        $this->assertInstanceOf(ClassA::class, $object);

        $classA = $this->container->getInstance(InterfaceA::class);
        $this->assertInstanceOf(ClassA::class, $classA);
    }

    /**
     * @test
     * @group bind
     */
    public function ShouldBindObjectUsingAClosure()
    {
        $classD = $this->container->bind('test', function () {
            return new ClassD();
        });

        $this->assertInstanceOf(ClassD::class, $classD);
    }

    /**
     * @test
     * @group make
     */
    public function ShouldMakeObject()
    {
        $res = $this->container->make(ClassC::class);

        $this->assertInstanceOf(ClassC::class, $res);
    }

    /**
     * @test
     * @group make
     */
    public function ShouldMakeObjectWithoutConstructor()
    {
        $res = $this->container->make(ClassD::class);

        $this->assertInstanceOf(ClassD::class, $res);
    }

    /**
     * @test
     * @group make
     */
    public function ShouldMakeObjectUsingClosure()
    {
        $res = $this->container->make(function () {
            return ClassC::class;
        });

        $this->assertInstanceOf(ClassC::class, $res);
    }
}
