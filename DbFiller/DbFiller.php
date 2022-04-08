<?php

namespace DbFiller;

use App\Models\DB\Db;
use App\Models\DB\DbParam;
use PDO;
use stdClass;

class DbFiller
{

    private Db $db;

    /** @var string[]  */
    private array $MANDATORY_LESSONS = ["AJ" => "Anglický jazyk", "ČJ" => "Český jazyk a literatura", "EN" => "Ekonomika",
        "IN" => "Informatika", "MA" => "Matematika", "TV" => "Tělesná výchova", "SV" => "Společenské vědy"];

    /** @var string[]  */
    private array $OTHER_LESSONS = ["DB" => "Databáze", "HW" => "Hardware", "MU" => "Multimédia", "PS" => "Počítače a sítě",
        "PG" => "Programování", "WA" => "Webové aplikace", "OS" => "Operační systémy", "GR" => "Grafika", "MP" => "Mikroprocesorová technika",
        "PX" => "Praxe", "EK" => "Elektronika", "EM" => "Elektrické měření"];

    /** @var string[]  */
    private array $MARKS = ["1" => "Výborný", "2" => "Chvalitebný", "3" => "Dobrý" , "4" => "Dostatečný", "5" => "Nedostatečný", "U" => "Uvolněn", "N" => "Nehodnocen"];

    /** @var array<array<string>> */
    private array $MARKS_CATEGORY = [["Aktivita", 1, "#bfb1ff"], ["Malá písemná práce", 2, "#45bd7c"], ["Zkoušení", 3, "#df6ba"], ["Velká písemná práce", 5, "#3c8baf"]];

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function fill(): void
    {
        $userCount = $this->db->getOne("SELECT COUNT(user_ID) as count FROM user", stdClass::class);

        if ($userCount->count < 1) {
            $this->fillUsers();
            $this->fillSubjects();
            $this->fillMarkType();
            $this->fillMarkCategory();
        }



    }

    private function fillUsers(): void
    {
        $test = file_get_contents("https://randomuser.me/api/?results=10&password=uppe,lower,18&inc=email,name,login&nat=US");
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


        foreach ($users as $user) {
            $psw_hashed = password_hash($user[3] . get_cfg_var("pepper"), PASSWORD_ARGON2ID);
            $this->db->exec("INSERT INTO user (email, first_name, last_name, password) VALUES (:email, :firstName, :lastName, :password)",
                [new DbParam("email", $user[0]), new DbParam("firstName", $user[1]), new DbParam("lastName", $user[2]),
                    new DbParam("password", $psw_hashed, PDO::PARAM_STR)]);
        }
    }

    private function fillSubjects(): void
    {
        $sql = "INSERT INTO subject (name, shortname) VALUES (:name, :shortName)";

        foreach ($this->MANDATORY_LESSONS as $shortName => $name) {
            $this->db->exec($sql, [new DbParam("name", $name), new DbParam("shortName", $shortName)]);
        }

        foreach ($this->OTHER_LESSONS as $shortName => $name) {
            $this->db->exec($sql, [new DbParam("name", $name), new DbParam("shortName", $shortName)]);
        }

    }

    private function fillMarkType(): void
    {
        $sql = "INSERT INTO mark_type (mark, description) VALUES (:mark, :desc)";

        foreach ($this->MARKS as $mark => $desc) {
            $this->db->exec($sql, [new DbParam("mark", $mark), new DbParam("desc", $desc)]);
        }
    }

    private function fillMarkCategory(): void
    {
        $sql = "INSERT INTO mark_category (label, weight, color) VALUES (:label, :weight, :color)";

        foreach ($this->MARKS_CATEGORY as $markCategory) {
            $this->db->exec($sql, [new DbParam("label", $markCategory[0]), new DbParam("weight", $markCategory[1], PDO::PARAM_INT), new DbParam("color", $markCategory[2])]);
        }
    }

}