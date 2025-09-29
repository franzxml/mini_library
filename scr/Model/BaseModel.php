<?php
namespace App\Model;


use App\Traits\Timestampable;
use JsonSerializable;


abstract class BaseModel implements JsonSerializable // inheritance + polymorphism (jsonSerialize)
{
use Timestampable; // trait


// Encapsulation via protected/private
protected ?int $id = null;


public const TABLE = ''; // constants; to be overridden


public function getId(): ?int { return $this->id; }


// Magic method for debug string
public function __toString(): string { return static::class . '#'.($this->id ?? 'new'); }


// Serialization to JSON
public function jsonSerialize(): array { return get_object_vars($this); }


// Cloning (deep-ish): reset id and timestamps
public function __clone()
{
$this->id = null; // new entity
$this->touch();
}
}