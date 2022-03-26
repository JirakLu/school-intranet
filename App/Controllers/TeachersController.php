<?php

namespace App\Controllers;

class TeachersController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.teachers");
    }
}