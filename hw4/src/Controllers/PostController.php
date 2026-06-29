<?php
namespace Otus\Hw4\Controllers;

use Otus\Hw4\Attributes\ControllerClass;
use Otus\Hw4\Attributes\HandlesPath;

#[ControllerClass]
class PostController
{

    #[HandlesPath('/post/save', 'POST')]
    public function save_post(): void
    {
        http_response_code(503);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'status' => 'fail',
            'message' => 'Service Temporarily Unavailable'
        ]);
    }
}
