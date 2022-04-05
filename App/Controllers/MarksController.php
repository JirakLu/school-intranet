<?php

namespace App\Controllers;

use App\Session;

class MarksController extends AController
{
    public function render(): void
    {
        if (Session::get("isLoggedIn")) {
            $this->renderView("pages.private.marks");
        } else {
            $this->redirect("restricted");
        }
    }
}