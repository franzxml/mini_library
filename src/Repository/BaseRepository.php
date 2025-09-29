<?php
namespace App\Repository;


use App\Core\DB;
use App\Model\BaseModel;
use PDO;


abstract class BaseRepository implements RepositoryInterface
{
protected PDO $pdo;
/** @var class-string<BaseModel> */
protected const MODEL = BaseModel::class;


public function __construct()
{
$this->pdo = DB::pdo();
}


// Late static binding: static::MODEL and static::TABLE used by children
protected function table(): string { /** @var class-string<BaseModel> $m */ $m = static::MODEL; return $m::TABLE; }


public function all(): array
{
$stmt = $this->pdo->query('SELECT * FROM ' . $this->table() . ' ORDER BY id DESC');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
return array_map(fn($r) => $this->mapToModel($r), $rows);
}


public function find(int $id): ?object
{
$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table() . ' WHERE id = :id');
$stmt->execute(['id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row ? $this->mapToModel($row) : null;
}


public function create(object $entity): object
{
if (! $entity instanceof BaseModel) throw new \InvalidArgumentException('Must be a BaseModel'); // Exception
$entity->touch();
$this->insert($entity);
return $entity;
}


abstract protected function insert(BaseModel $entity): void;
abstract protected function mapToModel(array $row): BaseModel;
}