<?php
namespace App\Core;

final class Autoloader
{
    private static string $basePath;

    public static function register(string $basePath): void
    {
        self::$basePath = rtrim($basePath, '/');
        spl_autoload_register([self::class, 'load']);
    }

    private static function load(string $class): void
    {
        if (! str_starts_with($class, 'App\\')) return;

        // Ubah: tambahkan 'src/' di depan path
        $relative = str_replace('App\\', 'src/', $class);
        $path = self::$basePath . '/' . str_replace('\\', '/', $relative) . '.php';

        if (is_file($path)) {
            require $path;
        }
    }
}