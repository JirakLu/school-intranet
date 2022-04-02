<?php

namespace App\Controllers;

use App\Session\Session;

class FilesController extends AController
{
    public function render(): void
    {
        if (Session::getIsLoggedIn()) {
            $this->renderView("pages.private.files");
        } else {
            $this->redirect("restricted");
        }
    }
}