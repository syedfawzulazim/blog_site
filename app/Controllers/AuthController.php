<?php
declare(strict_types=1);

namespace App\Controllers;

use App\core\View;
use App\Models\User;
use App\Models\Validators\InputValidator;
use mysql_xdevapi\Exception;

class AuthController
{
    public function showRegistrationForm(): string
    {
        return View::render('register');
    }

    public function register(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Method is not allowed";
            return '';
        }

        $errors = InputValidator::validateRegistration($_POST);

        if (empty($errors)) {
            $user = new User();
            if($user->create($_POST)){
                $_SESSION['success'] = 'Registration successful! Please login.';
                header('Location: /signin');

                exit;
            } else {
                return View::render('register', [
                    'errors' => ['Registration failed'],
                    'old' => $_POST // To repopulate the form
                ]);
            }
        } else {
                return View::render('register', [
                    'errors' => $errors,
                    'old' => $_POST // To repopulate the form
                ]);
            }
        return '';
    }


    public function showSignInForm(): string
    {
        return View::render('signin');
    }

    public function singin(): string
    {

    }

    }