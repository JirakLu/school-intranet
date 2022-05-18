<?php

namespace App\Controllers;

use App\Models\Files\FilesFacade;
use App\Session;

class FilesController extends AController
{

    /**
     * Controller for /files
     * @return void
     */
    public function renderFiles(): void
    {
        $this->privateRoute();
        $folders = new FilesFacade();
        $folders = $folders->getRootFolders(Session::get("userID"));
        $this->renderAuth("pages.private.files", "restricted", Session::get("isLoggedIn"), ["folders" => $folders, "menu" => ["home" => [true, "files"]]]);
    }

    /**
     * Controller for /files/***
     * @return void
     */
    public function folder(string $id): void
    {
        $this->privateRoute();
        $folders = new FilesFacade();
        $folders = $folders->getFolders($id, Session::get("userID"));
        $this->renderAuth("pages.private.files", "restricted", Session::get("isLoggedIn"), ["folders" => $folders]);
    }

}