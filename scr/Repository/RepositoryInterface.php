<?php
namespace App\Repository;


interface RepositoryInterface
{
public function all(): array;
public function create(object $entity): object;
public function find(int $id): ?object;
}