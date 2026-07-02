<?php
/* core helpers */

function render(string $template, array $context = []): void
{
    $templatePath = App::TPL_DIR . "/$template";
    if ( !file_exists($templatePath) || !is_file($templatePath) ) {
        throw new \RuntimeException("Template file not found: $templatePath");
    }
    extract($context);
    require $templatePath;
}

function require_helper(string $name): void
{
    $helperPath = App::HLP_DIR . "/$name.php";
    if ( !file_exists($helperPath) || !is_file($helperPath) ) {
        throw new \RuntimeException("Helper file not found: $helperPath");
    }
    require $helperPath;
}
