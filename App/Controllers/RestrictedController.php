<?php

namespace App\Controllers;

class RestrictedController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.access-restricted");
    }
}