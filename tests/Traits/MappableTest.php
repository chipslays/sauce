<?php

use PHPUnit\Framework\TestCase;
use Sauce\Traits\Mappable;
use Sauce\Traits\Singleton;

class MappableClass {
    use Mappable;
}

class MappableSecondClass {
    use Mappable;
}

final class MappableTest extends TestCase
{
    public function testSingleton()
    {
        $class = new MappableClass;
        $class->map('sum', fn(...$args) => array_sum($args));
        $this->assertEquals(1337, $class->sum(1000, 300, 30, 5, 2));

        $class::mapOnce('timestamp', fn() => time());
        $this->assertEquals($class::timestamp(), $class->timestamp());

        MappableSecondClass::map('sum', fn(...$args) => array_sum($args));
        $this->assertEquals(1337, MappableSecondClass::sum(1000, 300, 30, 5, 2));

        MappableSecondClass::mapOnce('timestamp', fn() => time());
        $this->assertEquals(MappableSecondClass::timestamp(), MappableSecondClass::timestamp());
    }
}