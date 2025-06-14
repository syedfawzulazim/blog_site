<?php
declare(strict_types=1);

namespace App\Controllers;

class HomeController{
    public function showHomePage(): void
    {
        require __DIR__ . '/../Views/home.php';
    }
    public function about(): void
    {
        echo "This is about page";
    }
}