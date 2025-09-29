<?php
namespace App\Core;


class Container
{
private array $bindings = [];


public function set(string $id, callable $factory): void { $this->bindings[$id] = $factory; }
public function get(string $id): mixed { return ($this->bindings[$id] ?? fn() => new $id())(); }
}