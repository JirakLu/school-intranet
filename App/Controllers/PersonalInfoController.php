<?php

namespace App\Controllers;

use App\Session;

class PersonalInfoController extends AController
{
    public function render(): void
    {
        if (Session::get("isLoggedIn")) {
            $this->renderView("pages.private.personal-info",
                ["firstName" => Session::get("firstName"), "lastName" => Session::get("lastName")]);
        } else {
            $this->redirect("restricted");
        }
    }
}