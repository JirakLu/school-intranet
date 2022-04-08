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

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function fill(): void
    {
        $userCount = $this->db->getOne("SELECT COUNT(user_ID) as count FROM user", stdClass::class);
        $subjectCount = $this->db->getOne("SELECT COUNT(subject_ID) as count FROM subject", stdClass::class);
        $markTypeCount = $this->db->getOne("SELECT COUNT(mark_type_ID) as count FROM mark_type", stdClass::class);
        $markCategoryCount = $this->db->getOne("SELECT COUNT(category_ID) as count FROM mark_category", stdClass::class);

        if ($userCount->count < 1) {
            $this->fillUsers();
        }

        if ($subjectCount->count < 1) {
            $this->fillSubjects();
        }

        if ($markTypeCount->count < 1) {
            $this->fillMarkType();
        }

        if ($markCategoryCount->count < 1) {
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


        $pepper = get_cfg_var("pepper");

        foreach ($users as $user) {
            $psw_peppered = hash_hmac("sha256", $user[3], $pepper);
            $psw_hashed = password_hash($psw_peppered, PASSWORD_ARGON2ID);
            $this->db->exec("INSERT INTO user (email, first_name, last_name, password) VALUES (:email, :firstName, :lastName, :password)",
                [new DbParam("email", $user[0], PDO::PARAM_STR), new DbParam("firstName", $user[1], PDO::PARAM_STR),
                    new DbParam("lastName", $user[2], PDO::PARAM_STR), new DbParam("password", $psw_hashed, PDO::PARAM_STR)]);
        }
    }

    private function fillSubjects(): void
    {
        $sql = "INSERT INTO subject (name, shortname) VALUES (:name, :shortName)";

        foreach ($this->MANDATORY_LESSONS as $shortName => $name) {
            $this->db->exec($sql, [new DbParam("name", $name), new DbParam("shortName", $shortName)]);
        }

        shuffle($this->OTHER_LESSONS);

        foreach ($this->OTHER_LESSONS as $shortName => $name) {
            $this->db->exec($sql, [new DbParam("name", $name), new DbParam("shortName", $shortName)]);
        }

    }

    private function fillMarkType(): void
    {
        $this->db->exec("INSERT INTO mark_type (mark, description) VALUES 
                 ('1','Výborný'),('2','Chvalitbený'),('3','Dobrý'),('4','Dostatečný'),('5','Nedostatečný'),('U','Uvolněn'),('N','Nehodnocen')");
    }

    private function fillMarkCategory(): void
    {
        $this->db->exec("INSERT INTO mark_category (label, weight, color) VALUES 
                 ('Aktivita',1,'#bfb1ff'),('Malá pisémná práce',2,'#45bd7c'),('Zkoušení',3,'#df6bab'),('Velká písmená práce',5,'#3c8baf')");
    }

}