<?php

namespace App\Models\Files;

class FilesFacade
{

    private FilesRepository $fileRepo;

    public function __construct()
    {
        $this->fileRepo = new FilesRepository();
    }

    public function getRootFolders(string $userID): array
    {
        return $this->fileRepo->getRootFolders($userID);
    }

    public function getFolders(string $id, string $userID): array
    {
        return $this->fileRepo->getFolders($id, $userID);
    }

    public function getFiles(string $id): array
    {
        return $this->fileRepo->getFiles($id);
    }

    public function getMenu(string $id): array
    {
        return $this->fileRepo->getMenu($id);
    }

}
