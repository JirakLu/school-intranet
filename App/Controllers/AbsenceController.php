<?php

namespace App\Controllers;

class AbsenceController extends AController
{
    public function render(): void
    {
        // TODO: authenticate
        $this->renderView("pages.private.absence");
    }
}