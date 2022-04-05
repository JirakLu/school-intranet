<?php

namespace App\Controllers;

use App\Session;

class AbsenceController extends AController
{
    public function render(): void
    {
        if (Session::get("isLoggedIn")) {
            $this->renderView("pages.private.absence",
                ["firstName" => Session::get("firstName"), "lastName" => Session::get("lastName")]);
        } else {
            $this->redirect("restricted");
        }
    }
}