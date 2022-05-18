<?php

namespace App\Models\Files;

use App\Models\DB\Db;
use App\Models\DB\DbParam;


class FilesRepository
{

    private Db $db;

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
}