<?php
namespace Otus\Hw4\Controllers;

use Otus\Hw4\Attributes\ControllerClass;
use Otus\Hw4\Attributes\HandlesPath;

#[ControllerClass]
class MainController
{
    #[HandlesPath('/')]
    public function index(): void
    {
        echo "<strong>UNDER CONSTRUCTION</strong>";
    }
}
