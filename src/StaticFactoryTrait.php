<?php

namespace StaticFactory;

trait StaticFactoryTrait
{
    protected static $bindings = [];

    protected static $defaultBinding = null;

    public static function bindings(): array
    {
        return static::$bindings;
    }

    public static function setBindings(array $bindings)
    {
        static::$bindings = $bindings;
    }

    public static function bind(string $key, $binding)
    {
        static::$bindings[$key] = $binding;
    }

    public static function unbind(string $key)
    {
        unset(static::$bindings[$key]);
    }

    public static function defaultBinding()
    {
        return static::$defaultBinding;
    }

    public static function bindDefault($binding)
    {
        static::$defaultBinding = $binding;
    }

    public static function unbindDefault()
    {
        static::$defaultBinding = null;
    }

    public static function make($type, ...$args)
    {
        return static::resolveBinding($type, ...$args);
    }

    protected static function resolveBinding(string $type, ...$args)
    {
        $binding = static::bindings()[$type] ?? static::$defaultBinding;

        if (is_string($binding)) {
            return new $binding(...$args);
        }

        if (is_callable($binding)) {
            return $binding(...$args);
        }

        if (is_object($binding)) {
            return $binding;
        }

        return null;
    }
}
