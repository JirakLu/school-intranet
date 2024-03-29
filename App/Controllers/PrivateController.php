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
        $this->renderAuth("pages.private.personal-info", "restricted", Session::get("isLoggedIn"));
    }

    /**
     * Controller for /files
     * @return void
     */
    public function renderFiles(): void
    {
        $this->renderAuth("pages.private.files", "restricted", Session::get("isLoggedIn"));
    }

    /**
     * Controller for /absence
     * @return void
     */
    public function renderAbsence(): void
    {
        $this->renderAuth("pages.private.absence", "restricted", Session::get("isLoggedIn"));
    }

}