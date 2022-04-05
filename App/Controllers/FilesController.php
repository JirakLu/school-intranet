<?php

namespace App\Controllers;

use App\Session;

class FilesController extends AController
{
    public function render(): void
    {
        if (Session::get("isLoggedIn")) {
            $this->renderView("pages.private.files");
        } else {
            $this->redirect("restricted");
        }
    }
}