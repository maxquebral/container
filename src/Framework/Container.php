<?php
/**
 * Author: MaxQuebral
 * Date: 9/4/17
 * Project: Container
 * Filename: Container.php
 */

namespace MaxQuebral\Framework;

class Container
{
    protected $instances = [];

    /**
     * Register a binding in the container
     *
     * @param $abstract
     * @param $concrete
     * @return mixed|null|object
     */
    public function bind($abstract, $concrete)
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
     * @return null|object
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

        // get constructor parameters
        $params = $constructor->getParameters();

        $dependencies = [];
        foreach ($params as $param) {
            // check if parameter is a class and instantiable
            if ($param->getClass() AND $param->getClass()->isInstantiable()) {
                // get the class
                $class = $param->getClass();

                if ($class->getConstructor()) {
                    // if class has a constructor, recurse and get dependencies
                    $dep = $this->make($class->getName());
                    $dependencies[] = $dep;
                } else {
                    $dependencies[] = $param->getClass()->newInstance();
                }

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
