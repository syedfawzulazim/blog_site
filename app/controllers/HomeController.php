<?php
declare(strict_types=1);

namespace App\controllers;

class HomeController{
    public function index(): void
    {
        require __DIR__ . '/../views/home.php';
    }
    public function about(): void
    {
        echo "This is about page";
    }
}