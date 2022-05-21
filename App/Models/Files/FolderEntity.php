<?php

namespace App\Models\Files;

class FolderEntity
{
    // FOLDER
    private string $folderID;
    private string $name;
    private string $path;
    private bool $private;
    private string $userID;
    private string|null $parentID = null;

    /**
     * @return string
     */
    public function getFolderID(): string
    {
        return $this->folderID;
    }

    /**
     * @param string $folderID
     */
    public function setFolderID(string $folderID): void
    {
        $this->folderID = $folderID;
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
     * @return bool
     */
    public function isPrivate(): bool
    {
        return $this->private;
    }

    /**
     * @param bool $private
     */
    public function setPrivate(bool $private): void
    {
        $this->private = $private;
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
    public function getParentID(): ?string
    {
        return $this->parentID;
    }

    /**
     * @param string|null $parentID
     */
    public function setParentID(?string $parentID): void
    {
        $this->parentID = $parentID;
    }


}
