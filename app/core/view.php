<?php
declare(strict_types=1);

namespace app\core;
class view
{
    public static function render(string $view, array $params = []): void
    {
        extract($params);
        require __DIR__ . $view . '.php';
    }
}