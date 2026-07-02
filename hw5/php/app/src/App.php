<?php

class App
{
    const string HLP_DIR = __DIR__ . "/helpers";
    const string TPL_DIR = __DIR__ . "/templates";
    const string CTL_DIR = __DIR__ . "/controllers";
    const string CONFIG_DIR = __DIR__ . "/../config";
    const string ROUTES_FILE = self::CONFIG_DIR . "/routes.cfg.php";

    private array $routes = [];
    private string $path = '';
    private string $tpl_404 = '404.phtml';

    public function __construct(bool $no_routes = false, bool $no_path = false)
    {
        if ( !$no_routes ) {
            $this->setRoutes(require self::ROUTES_FILE);
        }
        if ( !$no_path ) {
            $this->setPath($this->fetchPath());
        }
    }

    public function setPath(string $path): static
    {
        $this->path = $path;
        return $this;
    }

    public function setRoutes(array $routes): static
    {
        $this->routes = array_reverse($routes);
        return $this;
    }

    public static function templatePath(string $template): string
    {
        $templatePath = self::TPL_DIR . "/" . $template;
        if ( !file_exists($templatePath) || !is_file($templatePath) ) {
            throw new \RuntimeException("Template file not found: $templatePath");
        }
        return $templatePath;
    }

    public function setNotFoundPage(string $template_404): static
    {
        $this->tpl_404 = $template_404;
        return $this;
    }

    public function runPageNotFound(): void
    {
        http_response_code(404);
        require self::templatePath($this->tpl_404);
    }

    private function fetchPath(): string
    {
        if ( !isset($_SERVER['REQUEST_URI']) ) {
            return '';
        }
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return "/" . trim($path, "/");
    }

    private function findController(string $path): ?string
    {
        if ( $path === "" ) {
            $path = "/";
        }
        return array_find($this->routes, fn($controller, $route_path) => $route_path === $path);
    }

    public function runController(string $controller): void
    {
        $controllerPath = self::CTL_DIR . "/" . $controller;
        if ( !file_exists($controllerPath) || !is_file($controllerPath) ) {
            throw new \RuntimeException("Controller file not found: $controllerPath");
        }
        require $controllerPath;
    }

    public function run(): void
    {
        $controller = $this->findController($this->path);
        if ( $controller === null ) {
            // Не обрабатываем пути файлов (с расширениями)
            if ( !preg_match("~\\.[a-zA-Z][a-zA-Z0-9]*$~u", $this->path) ) {
                $this->runPageNotFound();
            }
            return;
        }
        $this->runController($controller);
    }
}
