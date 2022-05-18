<?php

namespace App\Controllers;

use App\Session;

class PrivateController extends AController
{

    /**
     * Controller for /personal-info
     * @return void
     */
    public function renderPersonalInfo(): void
    {
        $this->privateRoute();
        $this->renderAuth("pages.private.personal-info", "restricted", Session::get("isLoggedIn"));
    }

    /**
     * Controller for /absence
     * @return void
     */
    public function renderAbsence(): void
    {
        $this->privateRoute();
        $this->renderAuth("pages.private.absence", "restricted", Session::get("isLoggedIn"));
    }

}