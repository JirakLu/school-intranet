<?php

namespace App\Models\Files;

class FileEntity
{
    // FILE
    private string $fileID;
    private string $name;
    private string $path;
    private string $fileType;
    private string $userID;
    private string|null $folderID = null;

    /**
     * @return string
     */
    public function getFileID(): string
    {
        return $this->fileID;
    }

    /**
     * @param string $fileID
     */
    public function setFileID(string $fileID): void
    {
        $this->fileID = $fileID;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getFileType(): string
    {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     */
    public function setFileType(string $fileType): void
    {
        $this->fileType = $fileType;
    }

    /**
     * @return string
     */
    public function getUserID(): string
    {
        return $this->userID;
    }

    /**
     * @param string $userID
     */
    public function setUserID(string $userID): void
    {
        $this->userID = $userID;
    }

    /**
     * @return string|null
     */
    public function getFolderID(): ?string
    {
        return $this->folderID;
    }

    /**
     * @param string|null $folderID
     */
    public function setFolderID(?string $folderID): void
    {
        $this->folderID = $folderID;
    }


}