<?php

namespace DbFiller;

use App\Models\DB\Db;
use App\Models\DB\DbParam;
use PDO;

class DbFiller
{
    public function fillUsers(): void
    {

        $test = file_get_contents("https://randomuser.me/api/?results=10&password=upper,lower,18");
        $json = json_decode($test, true);
        $users = array_map(function ($user) {
            return [$user["email"], $user["name"]["first"], $user["name"]["last"], $user["login"]["password"]];
        }, $json["results"]);

        $myfile = fopen(__DIR__ . "/../DbFiller/users.txt", "w") or die("Unable to open file!");
        foreach ($users as $user) {
            $txt = $user[0] . "\t\t\t" . $user[3] . "\n";
            fwrite($myfile, $txt);
        }
        fclose($myfile);

        $db = new Db();

        $pepper = get_cfg_var("pepper");

        foreach ($users as $user) {
            $psw_peppered = hash_hmac("sha256", $user[3], $pepper);
            $psw_hashed = password_hash($psw_peppered, PASSWORD_ARGON2ID);
            $db->exec("INSERT INTO user (email, first_name, last_name, password) VALUES (:email, :firstName, :lastName, :password)",
                [new DbParam("email", $user[0], PDO::PARAM_STR), new DbParam("firstName", $user[1], PDO::PARAM_STR),
                new DbParam("lastName", $user[2], PDO::PARAM_STR), new DbParam("password", $psw_hashed, PDO::PARAM_STR)]);
        }


    }
}