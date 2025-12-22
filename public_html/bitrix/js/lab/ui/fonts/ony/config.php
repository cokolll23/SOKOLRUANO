<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$root = dirname(__DIR__, 6);
$extPath = str_replace($root, '', __DIR__);

return [
    "css" => $extPath . '/ui.font.ony.css',
];
