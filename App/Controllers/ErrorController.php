<?php

namespace App\Controllers;

use App\Session;

class ErrorController extends AController
{

    public function render404(): void
    {
        $this->renderView("pages.public.error404", ["isLoggedIn" => Session::get("isLoggedIn")]);
    }


}