<?php
declare(strict_types=1);

namespace App\controllers;

class AuthController{
    public function registrationView(): void
    {
        require __DIR__ . '/../views/register.php';
    }

    public function register($params, $queryParams)
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(405);
            echo "Mehtod is not allowed";
            return;
        }
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
    }

    public function signin(): void
    {
        require __DIR__ . '/../views/signin.php';
    }

}