<?php
namespace App\Core;


use App\Exception\NotFoundException;


class Router
{
private array $routes = ['GET' => [], 'POST' => []];
public function __construct(private Container $container) {}


public function get(string $path, callable|array $handler): void { $this->routes['GET'][$path] = $handler; }
public function post(string $path, callable|array $handler): void { $this->routes['POST'][$path] = $handler; }


public function dispatch(): void
{
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$handler = $this->routes[$method][$uri] ?? null;
if (!$handler) throw new NotFoundException('Route not found: ' . $uri);


if (is_array($handler)) { // [Class, method]
[$class, $methodName] = $handler;
$instance = $this->container->get($class);
echo $instance->$methodName();
} else {
echo $handler();
}
}
}