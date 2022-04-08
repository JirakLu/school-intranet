<?php

namespace App\Models\User;

use App\Models\DB\Db;
use App\Models\DB\DbParam;

class UserRepository {

    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function getUserByEmail(string $email): UserEntity|bool
    {
        $sql = "SELECT user_ID userID, email, password, first_name firstName, last_name lastName
                FROM user 
                WHERE email = :email";
        return $this->db->getOne($sql, UserEntity::class, [new DbParam("email", trim($email))]);
    }

    public function checkIfEmailExists(string $email): bool
    {
        $sql = "SELECT user_ID FROM user WHERE email = :email";
        return (bool) $this->db->getValue($sql, [new DbParam("email", trim($email))]);
    }

    public function getPassword(string $email): string|null
    {
        $sql = "SELECT password FROM user WHERE email = :email";
        return $this->db->getValue($sql, [new DbParam("email", trim($email))]);
    }

    public function updateUserLastLogin(string $id): void
    {
        $sql = "UPDATE user SET last_login = CURRENT_TIMESTAMP WHERE user_ID = :id";
        $this->db->exec($sql, [new DbParam("id", $id)]);
    }

    public function setUserAuthCookie(string $id, string $selector, string $authenticator): void
    {
        $sql = "UPDATE user SET auth_cookie = :authenticator, cookie_selector = :selector WHERE user_ID = :id";
        $this->db->exec($sql, [new DbParam("authenticator", $authenticator), new DbParam("selector", $selector), new DbParam("id", $id)]);
    }

    public function getUserBySelector(string $selector): UserEntity|bool
    {
        $sql = "SELECT user_ID userID, email, password, first_name firstName, last_name lastName, auth_cookie authCookie, cookie_selector cookieSelector
                FROM user 
                WHERE cookie_selector = :selector";
        return $this->db->getOne($sql, UserEntity::class, [new DbParam("selector", $selector)]);
    }

}