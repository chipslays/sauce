<?php

use PHPUnit\Framework\TestCase;
use Sauce\Traits\Singleton;

class SingletonClass {
    use Singleton;

    private $value;

    /**
     * @param mixed $value
     * @return static
     */
    public function set($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }
}

final class SingletonTest extends TestCase
{
    public function testSingleton()
    {
        $class1 = SingletonClass::getInstance()->set(1);
        $class2 = SingletonClass::getInstance()->set(2);
        SingletonClass::forgetInstance();
        $class3 = SingletonClass::getInstance()->set(3);

        $this->assertEquals(2, $class1->get());
        $this->assertEquals(2, $class2->get());
        $this->assertEquals(3, $class3->get());
    }
}