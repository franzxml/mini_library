<?php
namespace App\Model;


class Book extends BaseModel
{
public const TABLE = 'books';


// Properties with scopes
private string $title;
private string $author;


// Magic Methods __get/__set for controlled access (encapsulation)
public function __get(string $name): mixed
{
return match ($name) {
'title' => $this->title,
'author' => $this->author,
default => null
};
}


public function __set(string $name, mixed $value): void
{
if ($name === 'title' || $name === 'author') { $this->$name = (string)$value; }
}


public function __construct(string $title = '', string $author = '')
{
$this->title = $title; $this->author = $author; $this->touch();
}
}