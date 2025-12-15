<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

spl_autoload_register(function ($class) {
    if (!str_contains($class, 'Lab')) {
        return;
    }
    $classPath = str_replace('\\', '/', $class) . '.php';
    $file = __DIR__ . "/$classPath";
    if (file_exists($file)) {
        require_once $file;
    }
});