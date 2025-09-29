<?php
namespace App\Controller;


use App\Core\Http;
use App\Repository\MemberRepository;
use App\Model\Member;


class MemberController extends BaseController
{
private MemberRepository $repo;
public function __construct() { $this->repo = new MemberRepository(); }


public function index(): string
{
$members = $this->repo->all();
ob_start(); include __DIR__ . '/../../views/member/index.php'; return ob_get_clean();
}


public function create(): string
{
ob_start(); include __DIR__ . '/../../views/member/create.php'; return ob_get_clean();
}


public function store(): string
{
$m = new Member((string)Http::input('name', ''), (string)Http::input('email', ''));
$this->repo->create($m);
$this->redirect('/members');
return '';
}
}