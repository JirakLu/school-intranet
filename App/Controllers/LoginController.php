<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Session;

class LoginController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.login");
    }

    public function handleLogin(): void
    {
        // TODO: Handle login
        $model = new LoginModel();
        $success = $model->handleLogin();

        if ($success) {
            $this->redirect("dashboard");
        } else {
            $this->redirect("login");
        }
    }

    public function logout(): void
    {
        Session::destroy();
        $this->redirect("home");
    }
}