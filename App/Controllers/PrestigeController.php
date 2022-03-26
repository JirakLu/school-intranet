<?php

namespace App\Controllers;

class PrestigeController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.prestige");
    }
}