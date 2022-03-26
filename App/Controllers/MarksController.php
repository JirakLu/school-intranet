<?php

namespace App\Controllers;

class MarksController extends AController
{
    public function render(): void
    {
        // TODO: authenticate
        $this->renderView("pages.private.marks");
    }
}