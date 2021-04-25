# 🍅 Sauce

A sauce made from useful things.

# Installation

```bash
$ composer require chipslays/sauce
```

# Usage

## Singleton

A simple implementation of a Singleton as a trait.

```php
use Sauce\Traits\Singleton;

class Hero
{
    use Singleton;
}

$hero1 = Hero::getInstance();
$hero1->attack();

Hero::forgetInstance();
$hero2 = Hero::getInstance();
$hero2->attack();
```

```php
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

echo SingletonClass::getInstance()->set(1)->get(); // return 2
echo SingletonClass::getInstance()->set(2)->get(); // return 2

SingletonClass::forgetInstance();
echo SingletonClass::getInstance()->set(3)->get(); // return 3
```

## Mappable

When applied to a class, makes it possible to add methods to that class at runtime.

```php
use Sauce\Traits\MappableClass;

class MappableClass {
    use Mappable;
}

$class = new MappableClass;
$class->map('sum', fn(...$args) => array_sum($args));
echo $class->sum(1000, 300, 30, 5, 2) // 1337

$class::mapOnce('timestamp', fn() => time());
echo $class->timestamp(); // e.g. 1234567890
echo $class->timestamp(); // e.g. 1234567890
```

```php
use Sauce\Traits\MappableClass;

class MappableClass {
    use Mappable;
}

MappableClass::map('sum', fn(...$args) => array_sum($args));
echo MappableClass::sum(1000, 300, 30, 5, 2)

MappableClass::mapOnce('timestamp', fn() => time());
echo MappableClass::timestamp()
```

## Call

Call function or static/non-static classes.

```php
use Sauce\Traits\Call;

class MyClass {
    use Call;
}

$class = new MyClass;
$class->__call_function(fn () => true);
$class->__call_function('\App\Controllers\MainController@home');
$class->__call_function('\App\Controllers\MainController@users', [$id]);
```