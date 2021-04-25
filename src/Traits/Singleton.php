<?php

namespace Sauce\Traits;

use Sauce\Exceptions\Traits\SingletonException;

trait Singleton
{
    protected static $__singletonInstance;

    /**
     * Create a new instance of this singleton.
     *
     * @return static
     */
    final public static function getInstance()
    {
        return isset(static::$__singletonInstance)
            ? static::$__singletonInstance
            : static::$__singletonInstance = new static;
    }

    /**
     * Forget this singleton's instance if it exists.
     *
     * @return void
     */
    final public static function forgetInstance()
    {
        static::$__singletonInstance = null;
    }

    final protected function __construct()
    {
    }

    /**
     * @throws SingletonException
     */
    final public function __clone()
    {
        throw new SingletonException('You can not clone a singleton.');
    }

    /**
     * @throws SingletonException
     */
    final public function __wakeup()
    {
        throw new SingletonException('You can not deserialize a singleton.');
    }

    /**
     * @throws SingletonException
     */
    final public function __sleep()
    {
        throw new SingletonException('You can not serialize a singleton.');
    }
}
