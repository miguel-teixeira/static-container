<?php

namespace StaticFactory;

trait StaticSelfFactoryTrait
{
    protected static $binding = null;

    public static function binding()
    {
        return static::$binding;
    }

    public static function setBinding($binding)
    {
        static::$binding = $binding;
    }

    public static function resolve(...$args)
    {
        $binding = static::binding();

        if (is_string($binding)) {
            return new $binding(...$args);
        }

        if (is_callable($binding)) {
            return $binding(...$args);
        }

        if (is_object($binding)) {
            return $binding;
        }

        return new static(...$args);
    }

    public static function make(...$args)
    {
        return static::resolve(...$args);
    }
}