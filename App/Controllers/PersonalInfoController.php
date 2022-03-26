<?php

namespace App\Controllers;

class PersonalInfoController extends AController
{
    public function render(): void
    {
        // TODO: authenticate
        $this->renderView("pages.private.personal-info");
    }
}