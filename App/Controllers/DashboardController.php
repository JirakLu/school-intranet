<?php

namespace App\Controllers;

class DashboardController extends AController
{
    public function render(): void
    {
        // TODO: authenticate
        $this->renderView("pages.private.dashboard");
    }
}