<?php
declare(strict_types=1);


use App\Core\{Autoloader, Router, DB, Container};
use App\Controller\{BookController, MemberController};
use App\Exception\AppException;


// ===== Namespace & Autoloading (SPL) =====
require __DIR__ . '/../src/Core/Autoloader.php';
Autoloader::register(basePath: dirname(__DIR__));


// ===== Error handling global (Exception Handling) =====
set_exception_handler(function (Throwable $e) {
http_response_code(500);
echo '<h1>Application Error</h1><pre>' . htmlspecialchars($e->getMessage()) . '\n' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
});


// ===== Simple anonymous class as logger (Anonymous Class) =====
$logger = new class {
public function info(string $msg): void { error_log('[INFO] ' . $msg); }
};


// ===== Bootstrap DB (Static, Singleton-ish) =====
DB::init(__DIR__ . '/../storage/data.sqlite');
DB::migrate(); // create tables if not exist


// ===== Dependency Injection Container =====
$container = new Container();
$container->set(BookController::class, fn() => new BookController());
$container->set(MemberController::class, fn() => new MemberController());


// ===== Router (magic __invoke for handlers optional) =====
$router = new Router($container);


$router->get('/', function () {
return view('home');
});


// BOOK routes
$router->get('/books', [BookController::class, 'index']);
$router->get('/books/create', [BookController::class, 'create']);
$router->post('/books', [BookController::class, 'store']);
$router->get('/books/show', [BookController::class, 'show']);
$router->post('/books/clone', [BookController::class, 'cloneOne']);


// MEMBER routes
$router->get('/members', [MemberController::class, 'index']);
$router->get('/members/create', [MemberController::class, 'create']);
$router->post('/members', [MemberController::class, 'store']);


// DEBUG & Reflection
$router->get('/debug/reflection', function () {
$ref = new App\Util\Reflector();
return view('home', ['debug' => $ref->introspect(App\Model\Book::class)]);
});


// Dispatch
$logger->info($_SERVER['REQUEST_METHOD'] . ' ' . ($_SERVER['REQUEST_URI'] ?? '/'));
$router->dispatch();


// ===== Helpers =====
function view(string $name, array $data = []): void {
extract($data);
$viewFile = __DIR__ . '/../views/' . $name . '.php';
if (! file_exists($viewFile)) { throw new AppException('View not found: ' . $name); }
include __DIR__ . '/../views/layout.php';
}