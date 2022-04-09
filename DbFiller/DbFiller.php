<?php

namespace DbFiller;

use App\Models\DB\Db;
use App\Models\DB\DbParam;
use PDO;

class DbFiller
{

    private Db $db;

    /** @var string[] */
    private array $MANDATORY_LESSONS = ["AJ" => "Anglický jazyk", "ČJ" => "Český jazyk a literatura", "EN" => "Ekonomika",
        "IN" => "Informatika", "MA" => "Matematika", "TV" => "Tělesná výchova", "SV" => "Společenské vědy"];

    /** @var string[] */
    private array $OTHER_LESSONS = ["DB" => "Databáze", "HW" => "Hardware", "MU" => "Multimédia", "PS" => "Počítače a sítě",
        "PG" => "Programování", "WA" => "Webové aplikace", "OS" => "Operační systémy", "GR" => "Grafika", "MP" => "Mikroprocesorová technika",
        "PX" => "Praxe", "EK" => "Elektronika", "EM" => "Elektrické měření"];

    /** @var string[] */
    private array $MARKS = ["1" => "Výborný", "2" => "Chvalitebný", "3" => "Dobrý", "4" => "Dostatečný", "5" => "Nedostatečný", "U" => "Uvolněn", "N" => "Nehodnocen"];

    /** @var array<int, array<int, int|string>> */
    private array $MARKS_CATEGORY = [["Aktivita", 1, "#bfb1ff"], ["Malá písemná práce", 2, "#45bd7c"], ["Zkoušení", 3, "#df6ba"], ["Velká písemná práce", 5, "#3c8baf"]];

    /** @var string[] */
    private array $CLASSES = ["1.D", "2.D", "3.D"];

    private string $teachers = "";

    private string $students = "";

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function fill(): void
    {
        $userCount = $this->db->getValue("SELECT COUNT(user_ID) as count FROM user");


        $this->fillClasses();
        $this->fillSubjects();
        $this->fillMarkType();
        $this->fillMarkCategory();
        $this->generateTxt();


    }

    private function fillClasses(): void
    {
        foreach ($this->CLASSES as $class) {
            $user = $this->getUsers(1, true);
            $this->db->exec("INSERT INTO class SET class_name = :className, teacher_ID = (SELECT user_ID FROM user WHERE email = :email LIMIT 1)",
                [new DbParam("className", $class), new DbParam("email", $user[0]["email"])]);

            $classID = $this->db->lastInsertID();
            $users = $this->getUsers(24, false, $classID);

            // Whole group
            $this->db->exec("INSERT INTO `group` SET name = :name, class_ID = (SELECT class_ID FROM class WHERE class_ID = :classID LIMIT 1)",
                [new DbParam("name", $class), new DbParam("classID", $classID)]);

            //S1
            $this->db->exec("INSERT INTO `group` SET name = 'S1', class_ID = (SELECT class_ID FROM class WHERE class_ID = :classID LIMIT 1)",
                [new DbParam("classID", $classID)]);

            //S2
            $this->db->exec("INSERT INTO `group` SET name = 'S2', class_ID = (SELECT class_ID FROM class WHERE class_ID = :classID LIMIT 1)",
                [new DbParam("classID", $classID)]);

            foreach ($users as $index => $user) {
                $this->db->exec("INSERT INTO student_in_group SET student_ID = (SELECT user_ID FROM user WHERE email = :email), 
                                 group_ID = (SELECT group_ID FROM `group` WHERE name = :class && class_ID = :classID LIMIT 1)",
                    [new DbParam("email", $user["email"]), new DbParam("class", $class), new DbParam("classID", $classID)]);

                if ($index < 12) {
                    $this->db->exec("INSERT INTO student_in_group SET student_ID = (SELECT user_ID FROM user WHERE email = :email), 
                                 group_ID = (SELECT group_ID FROM `group` WHERE name = 'S1' && class_ID = :classID LIMIT 1)",
                        [new DbParam("email", $user["email"]), new DbParam("classID", $classID)]);
                } else {
                    $this->db->exec("INSERT INTO student_in_group SET student_ID = (SELECT user_ID FROM user WHERE email = :email), 
                                 group_ID = (SELECT group_ID FROM `group` WHERE name = 'S2' && class_ID = :classID LIMIT 1)",
                        [new DbParam("email", $user["email"]), new DbParam("classID", $classID)]);
                }
            }
        }
    }

    private function getUsers(int $count, bool $isTeacher, string $classId = ""): array
    {
        $test = file_get_contents("https://randomuser.me/api/?results=$count&password=upper,lower,18&inc=email,name,login&nat=US");
        $json = json_decode($test, true);
        $users = array_map(function ($user) {
            $password = password_hash($user["login"]["password"] . get_cfg_var("pepper"), PASSWORD_ARGON2ID);
            return ["email" => $user["email"], "firstName" => $user["name"]["first"],
                "lastName" => $user["name"]["last"], "passwordHash" => $password, "password" => $user["login"]["password"]];
        }, $json["results"]);

        $sql = "INSERT INTO user (email, password, first_name, last_name) 
                VALUES (:email, :password, :firstName, :lastName)";

        $usersV2 = [];

        if (!$isTeacher) {
            $className = $this->db->getValue("SELECT class_name FROM class WHERE class_ID = :classID", [new DbParam("classID", $classId)]);
            $this->students .= "\n\n------------------ CLASS - $className  ------------------";
        }

        foreach ($users as $index => $user) {
            $this->db->exec($sql, [new DbParam("email", $user["email"]), new DbParam("password", $user["passwordHash"]),
                new DbParam("firstName", $user["firstName"]), new DbParam("lastName", $user["lastName"])]);

            $userID = $this->db->lastInsertID();;

            if ($index === 0 && !$isTeacher) {
                $this->students .= "\n---------------- S1 ----------------" ;
            } else if ($index === 11 && !$isTeacher) {
                $this->students .= "\n---------------- S2 ----------------" ;
            }

            if ($isTeacher) {
                $this->db->exec("INSERT INTO teacher SET teacher_ID = ( SELECT user_ID FROM user WHERE email = :email LIMIT 1)",
                    [new DbParam("email", $user["email"])]);
                $this->teachers .= "\n" . $user["email"] . "\t\t" . $user["password"];
            } else {
                $this->db->exec("INSERT INTO student SET student_ID = ( SELECT user_ID FROM user WHERE email = :email), 
                        class_ID = (SELECT class_ID FROM class WHERE class.class_ID = :classID LIMIT 1)", [new DbParam("email", $user["email"]), new DbParam("classID", $classId)]);
                $this->students .= "\n" . $user["email"] . "\t\t" . $user["password"];
            }

            $usersV2[] = ["id" => $userID, "email" => $user["email"]];
        }

        if (!$isTeacher) {
            $this->students .= "\n---------------------- CLASS - END  ---------------------";
        }

        return $usersV2;
    }

    private function generateTxt(): void
    {
        $myfile = fopen(__DIR__ . "/../DbFiller/users.txt", "w") or die("Unable to open file!");

        fwrite($myfile, "\n\n------------ TEACHERS ------------");
        fwrite($myfile, $this->teachers);
        fwrite($myfile, "\n--------------------------------------");

        fwrite($myfile, "\n\n------------ STUDENTS ------------");
        fwrite($myfile, $this->students);
        fwrite($myfile, "\n--------------------------------------");


        fclose($myfile);
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