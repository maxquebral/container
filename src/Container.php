<?php
declare(strict_types=1);

namespace MaxQuebral\Container;

class Container
{
    /**
     * @var mixed[]
     */
    protected $instances = [];

    /**
     * Register a binding in the container
     *
     * @param $abstract
     * @param $concrete
     *
     * @return mixed|null|object
     */
    public function bind($abstract, $concrete): object
    {
        // check if already in the array of instances
        if ($this->getInstance($abstract)) {
            return $this->instances[$abstract];
        }

        // if concrete is a closure
        if ($concrete instanceof \Closure) {
            return $this->instances[$abstract] = $concrete();
        }

        return $this->instances[$abstract] = $this->make($concrete);
    }

    /**
     * Get the instance from the array
     *
     * @param $key
     * @return mixed|null
     */
    public function getInstance($key)
    {
        if (!array_key_exists($key, $this->instances)) {
            return null;
        }

        return $this->instances[$key];
    }

    /**
     * Make the object and all its dependencies
     *
     * @param $class
     *
     * @return null|object
     *
     * @throws \ReflectionException
     */
    public function make($class)
    {
        if ($class instanceof \Closure) {
            $reflection = new \ReflectionClass($class());
        } else {
            $reflection = new \ReflectionClass($class);
        }

        if (!$constructor = $reflection->getConstructor()) {
            return $reflection->newInstance();
        }

        // Get constructor parameters
        $params = $constructor->getParameters();

        $dependencies = [];
        foreach ($params as $param) {
            // Check if parameter is a class and instantiable
            if ($param->getClass() && $param->getClass()->isInstantiable()) {
                // Get the class
                $class = $param->getClass();

                if ($class->getConstructor()) {
                    // If class has a constructor, recurse and get dependencies
                    $dep = $this->make($class->getName());
                    $dependencies[] = $dep;

                    continue;
                }

                $dependencies[] = $param->getClass()->newInstance();

                continue;
            }

            if ($param->isOptional()) {
                $dependencies[] = $param->getDefaultValue();
            } elseif ($param->isArray()) {
                $dependencies[] = [];
            } else {
                $dependencies[] = '';
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }


}
