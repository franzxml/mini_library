<?php
namespace App\Collection;


use IteratorAggregate;
use Traversable;
use App\Model\Book;


class BooksCollection implements IteratorAggregate
{
/** @var Book[] */
private array $items;
public function __construct(array $items) { $this->items = $items; }
public function getIterator(): Traversable { yield from $this->items; }
}