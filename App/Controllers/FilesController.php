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
        $facade = new FilesFacade();
        $folders = $facade->getRootFolders(Session::get("user_ID"));
        $this->renderAuth("pages.private.files", "restricted", Session::get("isLoggedIn"), ["access" => true,"folders" => $folders, "files" => [], "menu" => ["root" => [true, ""]]]);
    }

    /**
     * Controller for /files/***
     * @param string $id
     * @return void
     */
    public function folder(string $id): void
    {
        $this->privateRoute();
        $facade = new FilesFacade();
        $menu = $facade->getMenu($id);
        $folders = $facade->getFolders($id, Session::get("user_ID"));
        $files = $facade->getFiles($id);
        $access = $facade->checkAccess($id, Session::get("user_ID"));
        $this->renderAuth("pages.private.files", "restricted", Session::get("isLoggedIn"), ["access" => $access, "folders" => $folders, "files" => $files, "menu" => $menu]);
    }

}