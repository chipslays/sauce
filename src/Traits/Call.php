<?php

namespace Sauce\Traits;

trait Call
{
    /**
     * Call anonymous function or class string (className@doSomething)
     *
     * @param callable|string $fn
     * @param array $parameters
     * @return mixed
     */
    public static function __call_function($fn, $parameters = [])
    {
        if (is_callable($fn)) {
            return call_user_func_array($fn, $parameters);
        } elseif (stripos($fn, '@') !== false) {
            [$controller, $method] = explode('@', $fn);

            try {
                $reflectedMethod = new \ReflectionMethod($controller, $method);
                if ($reflectedMethod->isPublic() && (!$reflectedMethod->isAbstract())) {
                    if ($reflectedMethod->isStatic()) {
                        return forward_static_call_array(array($controller, $method), $parameters);
                    } else {
                        if (is_string($controller)) {
                            $controller = new $controller();
                        }
                        return call_user_func_array(array($controller, $method), $parameters);
                    }
                }
            } catch (\ReflectionException $reflectionException) {
                // nothing...
            }
        }
    }
}
