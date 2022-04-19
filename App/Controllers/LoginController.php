<?php

namespace App\Controllers;

use App\Session;
use Services\AuthService;

class LoginController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.login");
    }

    public function handleLogin(): void
    {
        $authService = new AuthService();
        $user = $authService->handleAuth($_POST["email"], $_POST["password"]);


        if ($user) {
            if ($_POST["remember-me"]) $authService->setAuthCookie();
            cleanError();
            $this->redirect("marks");
        } else {
            $this->redirect("login");
        }
    }

    public function logout(): void
    {
        $authService = new AuthService();
        $authService->logout();

        $this->redirect("home");
    }
}