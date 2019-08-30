<?php
/**
 * Author: MaxQuebral
 * Date: 9/4/17
 * Project: Container
 * Filename: ClassB.php
 */

namespace Tests\Stubs;

class ClassB
{
    /**
     * @var ClassD
     */
    private $classD;

    public function __construct(ClassD $classD)
    {
        $this->classD = $classD;
    }
}
