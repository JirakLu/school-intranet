<?php

namespace App\Controllers;

use App\Session\Session;

class MarksController extends AController
{
    public function render(): void
    {
        if (Session::getIsLoggedIn()) {
            $this->renderView("pages.private.marks");
        } else {
            $this->redirect("restricted");
        }
    }
}