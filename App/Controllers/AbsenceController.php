<?php

namespace App\Controllers;

use App\Session\Session;

class AbsenceController extends AController
{
    public function render(): void
    {
        if (Session::getIsLoggedIn()) {
            $this->renderView("pages.private.absence");
        } else {
            $this->redirect("restricted");
        }
    }
}