# Static Factory
Trait helpers to make objects from a static method.

1. StaticFactoryTrait
2. StaticSelfFactoryTrait

# Usage

- StaticFactoryTrait
```php
Animal::bind('dog', Dog::class);
Animal::bind('cat', Cat::class);

// or

Animal::setBindings([
  'dog' => Dog::class,
  'cat' => Cat::class
])

// then

$dog = Animal::make('dog');

```

- StaticSelfFactoryTrait

```php
Animal::bind(Dog::class);

$dog = Animal::make();

// or, instead of using the new keyword

$elephant = Elephant::make();
```

# Recommendations

- Overwrite the make method in your abstract class to make sure it always returns Animal type.

```php
abstract class Animal {
  use StaticFactoryTrait;
  
  public static function make(string $type): Animal
  {
    return static::resolve($type);
  }
}

```

- Although you can pass constructor arguments in make, or you may pass from a setter method(s) like `with`.

```php

// constructor

Animal::make('dog', $height, $weight);

// or, if Animal has some setter method like `with`

Animal::make('dog')->with($height, $weight);
```

- With the self factory, you may also pass constructor arguments in make.

```php

Elephant::make($height, $weight);

```

# Considerations

I made and use this self factory, because I try to avoid newing up classes. 

- I think its ugly in some cases.

```php

// ugly

(new Elphant($height, $weight))->dance();

// elegant

Elephant::make($height, $weight)->dance();

```

- It becomes harder to test, but with a self factory you easily can mock. 

```php

Elephant::bind($mock);

Elephant::make($height, $weight)->dance();

```

# Have fun!

