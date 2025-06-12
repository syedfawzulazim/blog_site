<?php
declare(strict_types=1);

namespace App\controllers;

class AuthController{
    public function showRegistrationFrom(): void
    {
        require __DIR__ . '/../views/register.php';
    }

    public function register(): void
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(405);
            echo "Method is not allowed";
            return;
        }

        if(empty($_POST['name'])){
            die("Name is required");
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            die("Valid email required");
        }

        if(!$_POST['password'] === null || strlen($_POST['password']) < 4){
            die("Password is required");
        }
        $hashed_password =  password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    public function signin(): void
    {
        require __DIR__ . '/../views/signin.php';
    }

}