<?php

namespace App\Models\Files;

use App\Models\DB\Db;
use App\Models\DB\DbParam;


class FilesRepository
{

    private Db $db;

    private array $tempMenu;
    private string $tempID;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function getRootFolders(string $userID): array
    {
        $sql = "SELECT folder_ID folderID, name, path, private, parentID, user_ID userID
                FROM folder
                WHERE parentID IS NULL AND (private = 0 OR (private = 1 AND user_ID = :userID))";

        return $this->db->getAll($sql, FolderEntity::class, [new DbParam("userID", $userID)]);
    }

    public function getFolders(string $id, string $userID): array
    {
        $sql = "SELECT folder_ID folderID, name, path, private, parentID, user_ID userID
                FROM folder
                WHERE parentID = :id AND (private = 0 OR (private = 1 AND user_ID = :userID))";

        return $this->db->getAll($sql, FolderEntity::class, [new DbParam("id", $id), new DbParam("userID", $userID)]);
    }

    public function getFiles(string $id): array
    {
        $sql = "SELECT filer_ID fileID, name, path, file_type fileType, folder_ID folderID
                FROM file
                WHERE folder_ID = :id";

        return $this->db->getAll($sql, FileEntity::class, [new DbParam("id", $id)]);
    }

    public function getMenu(string $id): array
    {
        $this->tempMenu = [];
        $this->tempID = $id;

        $this->getParent($id);
        $this->tempMenu["root"] = [false, ""];

        return array_reverse($this->tempMenu);
    }

    private function getParent(string $id): void
    {
        $sql = "SELECT folder_ID folderID, name, path, private, parentID, user_ID userID
                FROM folder
                WHERE folder_ID= :id";
        /* @var $folder FolderEntity */
        $folder = $this->db->getOne($sql, FolderEntity::class,[new DbParam("id", $id)]);

        if ($folder->getParentID()) {
            $this->tempMenu[$folder->getName()] = [$id == $this->tempID, $folder->getFolderID()];
            $this->getParent($folder->getParentID());
        } else {
            $this->tempMenu[$folder->getName()] = [$id == $this->tempID, $folder->getFolderID()];
        }
    }
}