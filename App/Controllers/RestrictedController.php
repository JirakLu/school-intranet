<?php

namespace App\Controllers;

use App\Session;

class RestrictedController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.access-restricted", ["isLoggedIn" => Session::get("isLoggedIn")]);
    }
}