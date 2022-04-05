<?php

namespace App\Controllers;

use App\Session;

class SchoolController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.school", ["isLoggedIn" => Session::get("isLoggedIn")]);
    }
}