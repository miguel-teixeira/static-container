<?php

namespace StaticContainer;

trait StaticContainerTrait
{
    protected static $bindings = [];

    public static function resolve(string $type)
    {
        $binding = static::bindings()[$type] ?? null;

        if (is_string($binding)) {
            return new $binding();
        }

        if (is_callable($binding)) {
            return $binding();
        }

        return $binding;
    }

    public static function bindings(): array
    {
        return static::$bindings;
    }

    public static function setBindings(array $bindings)
    {
        static::$bindings = $bindings;
    }

    public static function bindClass(string $key, string $class)
    {
        static::$bindings[$key] = $class;
    }

    public static function bindCallback(string $key, callable $callable)
    {
        static::$bindings[$key] = $callable;
    }

    public static function unbind(string $key)
    {
        unset(static::$bindings[$key]);
    }
}