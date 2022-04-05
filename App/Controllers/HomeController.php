<?php

namespace App\Controllers;

use App\Session;

class HomeController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.index", ["isLoggedIn" => Session::get("isLoggedIn")]);
    }
}