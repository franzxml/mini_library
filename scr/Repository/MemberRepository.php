<?php
namespace App\Repository;


use App\Model\{Member, BaseModel};


class MemberRepository extends BaseRepository
{
protected const MODEL = Member::class;


protected function insert(BaseModel $entity): void
{
/** @var Member $entity */
$stmt = $this->pdo->prepare('INSERT INTO ' . $this->table() . ' (name, email, created_at, updated_at) VALUES (:n, :e, :c, :u)');
$stmt->execute([
'n' => $entity->jsonSerialize()['name'] ?? '',
'e' => $entity->jsonSerialize()['email'] ?? '',
'c' => $entity->getCreatedAt(),
'u' => $entity->getUpdatedAt(),
]);
$entityId = (int)$this->pdo->lastInsertId();
$ref = new \ReflectionClass($entity);
$prop = $ref->getParentClass()->getProperty('id');
$prop->setAccessible(true);
$prop->setValue($entity, $entityId);
}


protected function mapToModel(array $row): Member
{
$m = new Member((string)$row['name'], (string)$row['email']);
$ref = new \ReflectionClass($m);
$idProp = $ref->getParentClass()->getProperty('id');
$idProp->setAccessible(true);
$idProp->setValue($m, (int)$row['id']);
return $m;
}
}