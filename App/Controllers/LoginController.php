<?php

namespace App\Controllers;

class LoginController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.login");
    }

    public function handleLogin(): void
    {
        print_r($_POST);
        $this->forward("LoginController","render");
    }
}