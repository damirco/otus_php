<?php
use Damirco\Attr\ClassAttribute;
use Damirco\Attr\FunctionAttribute;
use Damirco\Attr\MethodAttribute;
use Otus\Hw4\Attributes\ControllerClass;
use Otus\Hw4\Attributes\HandlesPath;
use Otus\Hw4\Controllers\MainController;
use Otus\Hw4\Controllers\PostController;
use Otus\Hw4\Models\User;

require_once __DIR__ . "/vendor/autoload.php";

function page_not_found(): void
{
    http_response_code(404);
    echo "Page Not Found";
}

$blog_not_found = #[HandlesPath('/blog')] function () {
    page_not_found();
};

$user = new User('admin');
$mainController = new MainController();
$classAttribute = new ClassAttribute(ControllerClass::class);
$methodAttribute = new MethodAttribute(HandlesPath::class);
$functionAttribute = new FunctionAttribute(HandlesPath::class);

echo "Function page_not_found() has attribute HandlesPath: " .
    var_export($functionAttribute->isPresentOn('page_not_found'), true) . PHP_EOL;
echo "Function blog_not_found() has attribute HandlesPath: " .
    var_export($functionAttribute->isPresentOn($blog_not_found), true) . PHP_EOL;
echo "Class User has attribute ControllerClass: " .
    var_export($classAttribute->isPresentOn($user), true) . PHP_EOL;
echo "Class MainController has attribute ControllerClass: " .
    var_export($classAttribute->isPresentOn($mainController), true) . PHP_EOL;
echo "Class PostController has attribute ControllerClass: " .
    var_export($classAttribute->isPresentOn(PostController::class), true) . PHP_EOL;
echo "Method MainController::index() has attribute HandlesPath: " .
    var_export($methodAttribute->isPresentOn($mainController, 'index'), true) . PHP_EOL;
echo "Method PostController::save_post() has attribute HandlesPath: " .
    var_export($methodAttribute->isPresentOn(PostController::class . '::save_post', null), true) . PHP_EOL;
