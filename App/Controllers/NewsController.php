<?php

namespace App\Controllers;

use App\Session;

class NewsController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.news", ["isLoggedIn" => Session::get("isLoggedIn")]);
    }
}