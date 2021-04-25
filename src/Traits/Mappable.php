<?php

namespace Sauce\Traits;

use Sauce\Exceptions\Traits\MappableException;

trait Mappable
{
    use Call;

    /**
     * @var array
     */
    protected static $__mappedMethods = [];

    public static function map(string $method, $fn): void
    {
        if (method_exists(self::class, $method) || array_key_exists($method, self::$__mappedMethods)) {
            throw new MappableException("Cannot override an existing `{$method}` method.");
        }

        self::$__mappedMethods[$method] = $fn;
    }

    public static function mapOnce(string $method, $fn): void
    {
        if (method_exists(self::class, $method) || array_key_exists($method, self::$__mappedMethods)) {
            throw new MappableException("Cannot override an existing `{$method}` method.");
        }

        self::$__mappedMethods[$method] = self::__call_function($fn);
    }

    public function __call($method, $args)
    {
        $fn = self::$__mappedMethods[$method];
        return is_callable($fn) || class_exists($fn) ? $this->__call_function($fn, $args) : $fn;
    }

    public static function __callStatic($method, $args)
    {
        $fn = self::$__mappedMethods[$method];
        return is_callable($fn) || class_exists($fn) ? self::__call_function($fn, $args) : $fn;
    }
}