<?php
namespace App\Traits;


trait Timestampable
{
protected string $created_at = '';
protected string $updated_at = '';


public function touch(): void
{
$now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
if ($this->created_at === '') { $this->created_at = $now; }
$this->updated_at = $now;
}


public function getCreatedAt(): string { return $this->created_at; }
public function getUpdatedAt(): string { return $this->updated_at; }
}