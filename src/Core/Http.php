<?php
namespace App\Core;


class Http
{
public static function input(string $key, ?string $default = null): ?string
{ return $_POST[$key] ?? $_GET[$key] ?? $default; }
}