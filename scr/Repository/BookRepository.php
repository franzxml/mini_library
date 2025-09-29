<?php
namespace App\Repository;


use App\Model\{Book, BaseModel};
use PDO;


class BookRepository extends BaseRepository
{
protected const MODEL = Book::class; // used by base via late static binding


protected function insert(BaseModel $entity): void
{
/** @var Book $entity */
$stmt = $this->pdo->prepare('INSERT INTO ' . $this->table() . ' (title, author, created_at, updated_at) VALUES (:t, :a, :c, :u)');
$stmt->execute([
't' => $entity->title,
'a' => $entity->author,
'c' => $entity->getCreatedAt(),
'u' => $entity->getUpdatedAt(),
]);
$entityId = (int)$this->pdo->lastInsertId();
// Reflection to set protected property id
$ref = new \ReflectionClass($entity);
$prop = $ref->getParentClass()->getProperty('id');
$prop->setAccessible(true);
$prop->setValue($entity, $entityId);
}


protected function mapToModel(array $row): Book
{
$book = new Book((string)$row['title'], (string)$row['author']);
$ref = new \ReflectionClass($book);
$idProp = $ref->getParentClass()->getProperty('id');
$idProp->setAccessible(true);
$idProp->setValue($book, (int)$row['id']);


$ts = $ref->getParentClass()->getProperty('created_at');
$ts->setAccessible(true); $ts->setValue($book, (string)$row['created_at']);
$ts2 = $ref->getParentClass()->getProperty('updated_at');
$ts2->setAccessible(true); $ts2->setValue($book, (string)$row['updated_at']);
return $book;
}
}