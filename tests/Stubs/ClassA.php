<?php
/**
 * Author: MaxQuebral
 * Date: 9/4/17
 * Project: Container
 * Filename: ClassA.php
 */

namespace Tests\Stubs;

class ClassA implements InterfaceA
{
    private $fullName;

    public function __construct()
    {
        $this->fullName = 'this is the full name';
    }

    public function sampleMethod($var)
    {
        return $var;
    }
}
