<?php
namespace App\Controller;


use App\Core\Http;
use App\Repository\BookRepository;
use App\Model\Book;
use App\Collection\BooksCollection;


class BookController extends BaseController
{
private BookRepository $repo;
public function __construct() { $this->repo = new BookRepository(); } // DI via container


public function index(): string
{
$books = new BooksCollection($this->repo->all()); // Iteration
ob_start();
include __DIR__ . '/../../views/book/index.php';
return ob_get_clean();
}


public function create(): string
{
ob_start(); include __DIR__ . '/../../views/book/create.php'; return ob_get_clean();
}


public function store(): string
{
$title = (string)Http::input('title', '');
$author = (string)Http::input('author', '');
$book = new Book($title, $author); // type-safe via ctor
$this->repo->create($book);
$this->redirect('/books');
return '';
}


public function show(): string
{
$id = (int)(Http::input('id', '0'));
$book = $this->repo->find($id);
if (!$book) return 'Book not found';
// Serialization example: JSON view
header('Content-Type: application/json');
return json_encode($book, JSON_PRETTY_PRINT);
}


public function cloneOne(): string
{
$id = (int)(Http::input('id', '0'));
$book = $this->repo->find($id);
if (!$book) return 'Book not found';
$copy = clone $book; // Cloning
$copy->__set('title', $book->__get('title') . ' (Copy)');
$this->repo->create($copy);
$this->redirect('/books');
return '';
}
}