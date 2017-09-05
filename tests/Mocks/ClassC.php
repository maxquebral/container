<?php
/**
 * Author: MaxQuebral
 * Date: 9/4/17
 * Project: Container
 * Filename: ClassC.php
 */

namespace Tests\Mocks;

class ClassC
{
    /**
     * @var ClassA
     */
    private $classA;
    /**
     * @var ClassB
     */
    private $classB;
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $skills;

    public function __construct(ClassA $classA, ClassB $classB, $name, array $skills = [1, 2, 3])
    {
        $this->classA = $classA;
        $this->classB = $classB;
        $this->name = $name;
        $this->skills = $skills;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}
