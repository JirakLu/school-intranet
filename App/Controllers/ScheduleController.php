<?php

namespace App\Controllers;

use App\Session;

class ScheduleController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.schedule", ["isLoggedIn" => Session::get("isLoggedIn")]);
    }
}