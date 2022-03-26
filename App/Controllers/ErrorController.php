<?php

namespace App\Controllers;

class ErrorController extends AController
{

    public function render404(): void
    {
        $this->renderView("pages.public.error404");
    }


}