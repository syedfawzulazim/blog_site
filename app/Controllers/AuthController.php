<?php
declare(strict_types=1);

namespace App\Controllers;

use App\core\View;
use App\Models\User;
use App\Models\Validators\InputValidator;

class AuthController
{
    private User $user;
    private View $view;

    public function __construct(User $user, View $view)
    {
        $this->user = $user;
        $this->view = $view;
    }
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
            if($this->user->create($_POST)){
                $_SESSION['success'] = 'Registration successful! Please login.';
                header('Location: /signin');
                exit;
            } else {
                return  $this->view->render('register', [
                    'errors' => ['Registration failed'],
                    'old' => $_POST
                ]);
            }
        } else {
            return  $this->view->render('register', [
                'errors' => $errors,
                'old' => $_POST // To repopulate the form
            ]);
        }
    }

    public function showSignInForm(): string
    {
        return  $this->view->render('signin');
    }

    public function signin(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return  $this->view->render('signin', [
                'errors' => ['Method not allowed']
            ]);
        }

        $errors = InputValidator::validateLogin($_POST);

        if (empty($errors)) {
            $loggedInUser = $this->user->login($_POST['email'], $_POST['password']);

            if ($loggedInUser) {
                // Set session variables
                $_SESSION['user_id'] = $loggedInUser->getId();
                $_SESSION['user_name'] = $loggedInUser->getName();
                $_SESSION['user_email'] = $loggedInUser->getEmail();

                // Redirect to dashboard or home page
                header('Location: /');
                exit;
            } else {
                return  $this->view->render('signin', [
                    'errors' => ['Invalid email or password'],
                    'old' => $_POST
                ]);
            }
        }

        return  $this->view->render('signin', [
            'errors' => $errors,
            'old' => $_POST
        ]);
    }

    public function logout(): void
    {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        // Destroy the session
        session_destroy();

        // Redirect to home page
        header('Location: /');
        exit;
    }
}