<?php

namespace App\Controllers;

use App\Session;

class DashboardController extends AController
{
    public function render(): void
    {
        $this->renderAuth("pages.private.dashboard", "restricted", Session::get("isLoggedIn"));
    }
}