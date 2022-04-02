<?php

namespace App\Controllers;

use App\Session\Session;

class DashboardController extends AController
{
    public function render(): void
    {
        if (Session::getIsLoggedIn()) {
            $this->renderView("pages.private.dashboard");
        } else {
            $this->redirect("restricted");
        }
    }
}