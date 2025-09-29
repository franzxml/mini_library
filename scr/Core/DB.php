<?php
namespace App\Core;


use PDO;


class DB
{
private static ?PDO $pdo = null; // static property (shared state)


public static function init(string $sqlitePath): void
{
if (!is_dir(dirname($sqlitePath))) { mkdir(dirname($sqlitePath), 0777, true); }
self::$pdo = new PDO('sqlite:' . $sqlitePath);
self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}


public static function pdo(): PDO
{
if (! self::$pdo) { throw new \RuntimeException('DB not initialized'); }
return self::$pdo;
}


public static function migrate(): void
{
$sql = [
'CREATE TABLE IF NOT EXISTS books (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, author TEXT, created_at TEXT, updated_at TEXT)',
'CREATE TABLE IF NOT EXISTS members (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT, created_at TEXT, updated_at TEXT)'
];
foreach ($sql as $q) self::pdo()->exec($q);
}
}