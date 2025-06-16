<?php
declare(strict_types=1);

namespace App\Core;

class View
{
    public function render(string $view, array $params = []): string
    {
        $viewPath = dirname(__DIR__) . "/Views/{$view}.php";

        if (!file_exists($viewPath)) {
            throw new \Exception("View {$view} not found");
        }

        ob_start();
        extract($params);
        require $viewPath;

        $content = ob_get_clean();
        if ($content === false) {
            throw new \Exception("Failed to capture view output");
        }

        return $content;
    }
}