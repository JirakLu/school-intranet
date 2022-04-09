<?php

namespace App\Controllers;

use App\Models\Mark\MarkFacade;
use App\Session;

class MarksController extends AController
{
    public function render(): void
    {
        $markFacade = new MarkFacade();
        $marks = $markFacade->getMarksForUser(Session::get("user_ID"));

        $this->renderAuth("pages.private.marks", "restricted", Session::get("isLoggedIn"), ["marks" => $marks]);
    }
}