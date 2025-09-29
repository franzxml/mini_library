<?php
namespace App\Controller;


abstract class BaseController
{
final protected function redirect(string $to): void // final method
{
header('Location: ' . $to); exit;
}
}