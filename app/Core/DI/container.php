<?php

namespace App\Core\DI;

use Exception;
use ReflectionClass;

class Container
{
    private static ?Container $instance = null;
    private array $registry = [];

    private function __construct(){}

    public static function getInstance(): self
    {
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function set(string $name, \Closure $value): void
    {
        $this->registry[$name] = $value;
    }

    public function get(string $class): object
    {
        if(array_key_exists($class, $this->registry)){
            return $this->registry[$class]();
        }

        $reflector = new ReflectionClass($class);
        if (! $reflector->isInstantiable()) {
            throw new Exception("Target [$class] is not instantiable.");
        }

        $constructor = $reflector->getConstructor();
        if($constructor === null){
            return new $class;
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter){
            $type = $parameter->getType();
            $dependencies[] = $this->get($type->getName());
        }
        return new $class(...$dependencies);
    }
}