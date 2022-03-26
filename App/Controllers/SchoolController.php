<?php

namespace App\Controllers;

class SchoolController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.school");
    }
}