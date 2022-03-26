<?php

namespace App\Controllers;

class FilesController extends AController
{
    public function render(): void
    {
        // TODO: authenticate
        $this->renderView("pages.private.files");
    }
}