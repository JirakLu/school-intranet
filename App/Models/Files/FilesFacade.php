<?php

namespace App\Models\Files;

class FilesFacade
{

    private FilesRepository $fileRepo;

    public function __construct()
    {
        $this->fileRepo = new FilesRepository();
    }

    public function checkAccess(string $id, string $userID): bool
    {
        return $this->fileRepo->checkAccess($id, $userID);
    }

    public function getFilePath(string $id): string
    {
        return $this->fileRepo->getFilePath($id);
    }

    public function getFolderPath(string $id): string
    {
        return $this->fileRepo->getFolderPath($id);
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

    public function createFolder(string $parent, string $name, string $userID, bool $private): string {
        return $this->fileRepo->createFolder($parent, $name, $userID, $private);
    }

    public function removeFile(string $id, string $userID): void
    {
        $this->fileRepo->removeFile($id, $userID);
    }

    public function addFile(string $name, string $parent, string $fileType): string
    {
        return $this->fileRepo->addFile($name, $parent, $fileType);
    }


}
