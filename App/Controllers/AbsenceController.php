<?php

namespace App\Controllers;

use App\Session;

class AbsenceController extends AController
{
    public function render(): void
    {
        if (Session::get("isLoggedIn")) {
            $this->renderView("pages.private.absence");
        } else {
            $this->redirect("restricted");
        }
    }
}