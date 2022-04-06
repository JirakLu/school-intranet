<?php

namespace App\Controllers;

use App\Session;

class MarksController extends AController
{
    public function render(): void
    {
        $this->renderAuth("pages.private.marks", "restricted", Session::get("isLoggedIn"));
    }
}