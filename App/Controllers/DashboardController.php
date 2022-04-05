<?php

namespace App\Controllers;

use App\Session;

class DashboardController extends AController
{
    public function render(): void
    {
        if (Session::get("isLoggedIn")) {
            $this->renderView("pages.private.dashboard");
        } else {
            $this->redirect("restricted");
        }
    }
}