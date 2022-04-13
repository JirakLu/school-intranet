<?php

namespace DbFiller;

use App\Models\DB\Db;
use App\Models\DB\DbParam;
use PDO;
use stdClass;


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
    private array $MARKS_CATEGORY = [["Aktivita", 1, "#bfb1ff"], ["Malá písemná práce", 2, "#45bd7c"], ["Zkoušení", 3, "#df6baa"], ["Velká písemná práce", 5, "#3c8baf"]];

    /** @var string[] */
    private array $CLASSES = ["1.D", "2.D"];

    private string $teachers = "";

    private string $students = "";

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function fill(): void
    {
        $this->fillClasses();
        $this->fillSubjects();
        $this->fillMarkType();
        $this->fillMarkCategory();
        $this->fillCourses();
        $this->fillMarks();
        $this->generateGarant();
        $this->generateTxt();
    }

    private function fillMarks(): void
    {
        $students = $this->db->getAll("SELECT student_ID FROM student", stdClass::class);
        $markCategoryID = $this->db->getAll("SELECT category_ID FROM mark_category", stdClass::class);
        $markCategoryID = array_map(function ($mark) {
            return $mark->category_ID;
        }, $markCategoryID);

        foreach($students as $student) {
            $studentID = $student->student_ID;

            $courses = $this->db->getAll("SELECT course_ID FROM course
                                JOIN `group` ON course.group_ID = `group`.group_ID
                                JOIN student_in_group ON `group`.group_ID = student_in_group.group_ID
                                WHERE student_in_group.student_ID = :studentID",
                stdClass::class, [new DbParam("studentID", 39, PDO::PARAM_INT)]);

            foreach ($courses as $course) {
                $courseID = $course->course_ID;

                $rand = rand(3,10);
                for ($i = 0; $i < $rand; $i++) {
                    $markTypeID = array_rand(array_flip([1,2,3,4,5]));
                    $markCategoryID = array_rand(array_flip([1,2,3,4]));

                    $this->db->exec("INSERT INTO mark SET date = date_add('2022-03-01', INTERVAL RAND()*30 DAY), latka = 'Multimateriál', description = '1+(3+1+3+3uv-½uv)+(1+6+2+4uv)+(1+6+2+4uv) = 36,5 ~ 96 %', 
                                        course_ID = (SELECT course_ID FROM course WHERE course_ID = :courseID LIMIT 1),
                                        student_ID = (SELECT student_ID FROM student WHERE student_ID = :studentID LIMIT 1), 
                                        mark_category_ID = (SELECT category_ID FROM mark_category WHERE category_ID = :markCategoryID LIMIT 1),
                                        mark_type_ID = (SELECT mark_type_ID FROM mark_type WHERE mark_type_ID = :markTypeID LIMIT 1)",
                        [new DbParam("courseID", $courseID), new DbParam("studentID", $studentID),
                            new DbParam("markCategoryID", $markCategoryID), new DbParam("markTypeID", $markTypeID)]);
                }
            }
        }
    }

    private function generateGarant(): void
    {
        $teachers = $this->db->getAll("SELECT teacher_ID FROM teacher", stdClass::class);
        $teachers = array_map(function ($teacher) {
            return $teacher->teacher_ID;
        }, $teachers);

        $sql = "UPDATE subject SET teacher_ID = (SELECT teacher_ID FROM teacher WHERE teacher.teacher_ID = :id) WHERE subject.shortname = :subjectName";

        foreach ($this->MANDATORY_LESSONS as $shortName => $name) {
            $this->db->exec($sql, [new DbParam("subjectName", $shortName), new DbParam("id", array_rand(array_flip($teachers)))]);
        }

        foreach ($this->OTHER_LESSONS as $shortName => $name) {
            $this->db->exec($sql, [new DbParam("subjectName", $shortName), new DbParam("id", array_rand(array_flip($teachers)))]);
        }


    }

    private function fillCourses(): void
    {
        $this->getUsers(10, true);

        $classes = $this->db->getAll("SELECT * FROM class", stdClass::class);
        $teachers = $this->db->getAll("SELECT teacher_ID FROM teacher", stdClass::class);
        $teachers = array_map(function ($teacher) {
            return $teacher->teacher_ID;
        }, $teachers);

        foreach($classes as $class) {
            $groups = $this->db->getAll("SELECT * FROM `group` WHERE class_ID = :classID", stdClass::class, [new DbParam("classID", $class->class_ID)]);

            foreach ($this->MANDATORY_LESSONS as $lesson) {
                $this->db->exec("INSERT INTO course SET subject_ID = (SELECT subject_ID FROM subject WHERE name = :lessonName LIMIT 1),
                    group_ID = (SELECT group_ID FROM `group` WHERE group_ID = :groupID LIMIT 1), 
                    teacher_ID = (SELECT teacher_ID FROM teacher WHERE teacher_ID = :teacherID LIMIT 1)",
                    [new DbParam("lessonName", $lesson), new DbParam("groupID", $groups[0]->group_ID),
                        new DbParam("teacherID", array_rand(array_flip($teachers), 1))]);
            }

            $otherLessons = [];
            shuffle($this->OTHER_LESSONS);
            for ($i = 0; $i <= 5; $i++) {
                $otherLessons[] = $this->OTHER_LESSONS[$i];
            }

            foreach ($otherLessons as $lesson) {
                $this->db->exec("INSERT INTO course SET subject_ID = (SELECT subject_ID FROM subject WHERE name = :lessonName LIMIT 1),
                    group_ID = (SELECT group_ID FROM `group` WHERE group_ID = :groupID LIMIT 1), 
                    teacher_ID = (SELECT teacher_ID FROM teacher WHERE teacher_ID = :teacherID LIMIT 1)",
                    [new DbParam("lessonName", $lesson), new DbParam("groupID", $groups[1]->group_ID),
                        new DbParam("teacherID", array_rand(array_flip($teachers), 1))]);

                $this->db->exec("INSERT INTO course SET subject_ID = (SELECT subject_ID FROM subject WHERE name = :lessonName LIMIT 1),
                    group_ID = (SELECT group_ID FROM `group` WHERE group_ID = :groupID LIMIT 1), 
                    teacher_ID = (SELECT teacher_ID FROM teacher WHERE teacher_ID = :teacherID LIMIT 1)",
                    [new DbParam("lessonName", $lesson), new DbParam("groupID", $groups[2]->group_ID),
                        new DbParam("teacherID", array_rand(array_flip($teachers), 1))]);
            }
        }
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
            } else if ($index === 12 && !$isTeacher) {
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