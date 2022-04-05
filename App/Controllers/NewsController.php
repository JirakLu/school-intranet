<?php

namespace App\Controllers;

class NewsController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.news");
    }
}