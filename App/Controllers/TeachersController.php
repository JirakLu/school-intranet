<?php

namespace App\Controllers;

use App\Session;

class TeachersController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.teachers");
    }
}