<?php

namespace App\Models\Files;

use App\Models\DB\Db;
use App\Models\DB\DbParam;
use PDO;
use stdClass;


class FilesRepository
{

    private Db $db;

    private array $tempMenu;
    private string $tempID;
    private array $folderToRemove = [];

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function checkAccess(string $id, string $userID): bool
    {
        return !!$this->db->getValue("SELECT COUNT(*) FROM folder WHERE folder_ID = :folderID AND user_ID = :userID", [new DbParam("folderID", $id), new DbParam("userID", $userID)]);
    }

    public function getRootFolders(string $userID): array
    {
        $sql = "SELECT folder_ID folderID, name, path, private, parent_ID parentID, user_ID userID
                FROM folder
                WHERE parent_ID IS NULL AND (private = 0 OR (private = 1 AND user_ID = :userID))";


        return $this->db->getAll($sql, FolderEntity::class, [new DbParam("userID", $userID)]);
    }

    public function getFolders(string $id, string $userID): array
    {
        $sql = "SELECT folder_ID folderID, name, path, private, parent_ID parentID, user_ID userID
                FROM folder
                WHERE parent_ID = :id AND (private = 0 OR (private = 1 AND user_ID = :userID))";

        return $this->db->getAll($sql, FolderEntity::class, [new DbParam("id", $id), new DbParam("userID", $userID)]);
    }

    public function getFiles(string $id): array
    {
        $sql = "SELECT file_ID fileID, name, path, file_type fileType, folder_ID folderID
                FROM file
                WHERE folder_ID = :id";

        return $this->db->getAll($sql, FileEntity::class, [new DbParam("id", $id)]);
    }

    public function removeFile(string $id, string $userID): void
    {
        $path = $this->db->getValue("SELECT file.path FROM file JOIN folder f on f.folder_ID = file.folder_ID WHERE file.file_ID = :fileID AND f.user_ID = :userID",
            [new DbParam("fileID", $id), new DbParam("userID", $userID)]);

        $sql = "DELETE file.* FROM file 
                JOIN folder f on file.folder_ID = f.folder_ID
                WHERE file.file_ID = :fileID AND f.user_ID = :userID";
        $this->db->exec($sql, [new DbParam("fileID", $id), new DbParam("userID", $userID)]);
    }

    public function removeFolder(string $id, string $userID): void
    {
        $folder = $this->db->getAll("SELECT path, folder_ID folderID FROM folder WHERE parent_ID = :folderID AND user_ID = :userID"
            , stdClass::class, [new DbParam("folderID", $id), new DbParam("userID", $userID)]);

        $this->db->exec("DELETE file.* FROM file 
                            JOIN folder f on file.folder_ID = f.folder_ID
                            WHERE file.folder_ID = :folderID AND f.user_ID = :userID",
            [new DbParam("folderID", $id), new DbParam("userID", $userID)]);

        if (count($folder) > 0) {
            foreach ($folder as $f) {
                $this->removeFolder($f->folderID, $userID);
            }
        }
        if ($this->db->getValue("SELECT count(*) FROM folder WHERE folder_ID = :folderID AND user_ID = :userID", [new DbParam("folderID", $id), new DbParam("userID", $userID)])) {
            $this->db->exec("DELETE folder.* FROM folder WHERE folder_ID = :folderID AND user_ID = :userID",
                [new DbParam("folderID", $id), new DbParam("userID", $userID)]);
        }
    }

    public function checkFileAccess(string $id, string $userID): bool
    {
        return $this->db->getValue("SELECT count(*) 
                                        FROM file 
                                        JOIN folder f on f.folder_ID = file.folder_ID
                                        WHERE file.file_ID = :fileID AND f.user_ID = :userID", [new DbParam("fileID", $id), new DbParam("userID", $userID)]);
    }

    public function checkFolderAccess(string $id, string $userID): bool
    {
        return $this->db->getValue("SELECT count(*) FROM folder 
                                        WHERE folder_ID = :folderID AND user_ID = :userID", [new DbParam("folderID", $id), new DbParam("userID", $userID)]);
    }

    public function checkFolderPrivate(string $id): bool
    {
        return $this->db->getValue("SELECT count(*) FROM folder WHERE folder_ID = :folderID AND private = 1", [new DbParam("folderID", $id)]);
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
        $sql = "SELECT folder_ID folderID, name, path, private, parent_ID parentID, user_ID userID
                FROM folder
                WHERE folder_ID= :id";
        /* @var $folder FolderEntity */
        $folder = $this->db->getOne($sql, FolderEntity::class, [new DbParam("id", $id)]);

        if ($folder->getParentID()) {
            $this->tempMenu[$folder->getName()] = [$id == $this->tempID, $folder->getFolderID()];
            $this->getParent($folder->getParentID());
        } else {
            $this->tempMenu[$folder->getName()] = [$id == $this->tempID, $folder->getFolderID()];
        }
    }

    public function getFileInfo(string $id): array
    {
        $file = $this->db->getOne("SELECT path, name, folder_ID folderID FROM file WHERE file_ID = :id", stdClass::class, [new DbParam("id", $id)]);
        return ["path" => $file->path, "name" => $file->name, "folderID" => $file->folderID];
    }

    public function getFolderInfo(string $id): array
    {
        $folder = $this->db->getOne("SELECT path, name, private FROM folder WHERE folder_ID = :id", stdClass::class, [new DbParam("id", $id)]);
        return ["path" => $folder->path, "name" => $folder->name, "private" => $folder->private];
    }

    public function createFolder(string $parent, string $name, string $userID, bool $private): string
    {
        $path = "";
        if ($parent) {
            $path = $this->db->getValue("SELECT path FROM folder WHERE folder_ID = :folderID", [new DbParam("folderID", $parent)]);
        }

        $sql = "INSERT INTO folder SET name = :name, path = '', private = :private, parent_ID = (SELECT folder_ID FROM folder f WHERE f.folder_ID = :parent LIMIT 1), user_ID = :user";
        $this->db->exec($sql, [new DbParam("name", $name), new DbParam("private", $private ? 1 : 0, PDO::PARAM_INT),
            new DbParam("parent", $parent), new DbParam("user", $userID)]);

        $name = "/" . $this->db->lastInsertID() . "-" . $name;
        $name = strtolower($name);
        $this->db->exec("UPDATE folder SET path = :path WHERE folder_ID = :folder", [new DbParam("path", $path . $name), new DbParam("folder", $this->db->lastInsertID())]);

        return $path . $name;
    }

    public function addFile(string $name, string $parent, string $fileType): string
    {
        $path = $this->db->getValue("SELECT path FROM folder WHERE folder_ID = :folderID", [new DbParam("folderID", $parent)]);

        $sql = "INSERT INTO file SET name = :name, path = '', file_type = :fileType, folder_ID = (SELECT folder_ID FROM folder WHERE folder_ID = :parent LIMIT 1)";
        $this->db->exec($sql, [new DbParam("name", $name), new DbParam("fileType", $fileType), new DbParam("parent", $parent)]);

        $name = "/" . $this->db->lastInsertID() . "-" . $name;
        $name = strtolower($name);

        $this->db->exec("UPDATE file SET path = :path WHERE file_ID = :file", [new DbParam("path", $path . $name), new DbParam("file", $this->db->lastInsertID())]);

        return $path . $name;
    }
}