<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Session;

class LoginController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.login",
            ["isLoggedIn" => Session::get("isLoggedIn"), "showError" => Session::get("showError"), "error" => Session::get("error")]);
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
        Session::start();
        $this->redirect("home");
    }
}