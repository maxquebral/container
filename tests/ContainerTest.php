<?php
declare(strict_types=1);

namespace Tests;

use MaxQuebral\Container\Container;
use Tests\Stubs\ClassA;
use Tests\Stubs\ClassC;
use Tests\Stubs\ClassD;
use Tests\Stubs\InterfaceA;

class ContainerTest extends TestCase
{
    /** @var \MaxQuebral\Container\Container $container */
    private $container;

    /**
     * @test
     *
     * @throws \ReflectionException
     */
    public function ShouldMakeObjectUsingClosure()
    {
        $res = $this->container->make(function () {
            return ClassC::class;
        });

        self::assertInstanceOf(ClassC::class, $res);
    }

    public function setUp()
    {
        $this->container = new Container();
    }

    /**
     * Bind object.
     *
     * @return void
     */
    public function testShouldBindObjectAndGetInstanceFromTheContainer(): void
    {
        $object = $this->container->bind(InterfaceA::class, ClassA::class);
        self::assertInstanceOf(ClassA::class, $object);

        $classA = $this->container->getInstance(InterfaceA::class);
        self::assertInstanceOf(ClassA::class, $classA);
    }

    /**
     * Bind object a closure.
     *
     * @return void.
     */
    public function testShouldBindObjectUsingAClosure(): void
    {
        $classD = $this->container->bind('test', function () {
            return new ClassD();
        });

        self::assertInstanceOf(ClassD::class, $classD);
    }

    /**
     * Make an instance
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testShouldMakeObject(): void
    {
        $res = $this->container->make(ClassC::class);

        self::assertInstanceOf(ClassC::class, $res);
    }

    /**
     * Make an object with constructor.
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testShouldMakeObjectWithoutConstructor(): void
    {
        $res = $this->container->make(ClassD::class);

        self::assertInstanceOf(ClassD::class, $res);
    }
}
