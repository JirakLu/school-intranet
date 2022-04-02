<?php

namespace App\Controllers;

use App\Session\Session;

class PersonalInfoController extends AController
{
    public function render(): void
    {
        if (Session::getIsLoggedIn()) {
            $this->renderView("pages.private.personal-info");
        } else {
            $this->redirect("restricted");
        }
    }
}