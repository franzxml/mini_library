<?php
namespace App\Core;


final class Autoloader // final keyword
{
private static string $basePath;


public static function register(string $basePath): void
{
self::$basePath = rtrim($basePath, '/');
spl_autoload_register([self::class, 'load']); // Namespace & Autoloading
}


private static function load(string $class): void
{
if (! str_starts_with($class, 'App\\')) return;
$path = self::$basePath . '/' . str_replace('\\', '/', $class) . '.php';
if (is_file($path)) require $path;
}
}