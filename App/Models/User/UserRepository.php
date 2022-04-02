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
        $sql = "SELECT user_ID userID, email, password, first_name firstName, last_name lastName, auth_cookie authCookie, last_login lastLoginDate 
                FROM user 
                WHERE email = :email";
        return $this->db->getOne($sql, UserEntity::class, [new DbParam("email",$email)]);
    }

}