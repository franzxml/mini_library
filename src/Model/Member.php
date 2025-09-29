<?php
namespace App\Model;


class Member extends BaseModel
{
public const TABLE = 'members';


protected string $name = '';
protected string $email = '';


public function __construct(string $name = '', string $email = '')
{
$this->name = $name; $this->email = $email; $this->touch();
}
}