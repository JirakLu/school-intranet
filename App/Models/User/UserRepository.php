<?php

namespace App\Models\User;

use App\Models\DB\Db;
use App\Models\DB\DbParam;
use stdClass;

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

    public function getTeachingByID(string $id): array
    {
        $classTeacher = $this->db->getAll("SELECT class_name, class_ID FROM class WHERE teacher_ID = :id", stdClass::class, [new DbParam("id", $id)]);

        if ($classTeacher) {
            $classTeacher = array_map(function($class) {
                return ["title" => $class->class_name, "id" => $class->class_ID];
            }, $classTeacher);
        }
        $courseTeacher = $this->db->getAll("SELECT course.course_ID, class.class_name, class.class_ID, `group`.name as group_name, `group`.group_ID, subject.name, subject.subject_ID
                                                FROM course
                                                JOIN subject ON course.subject_ID = subject.subject_ID
                                                JOIN `group` ON course.group_ID = `group`.`group_ID`
                                                JOIN class ON `group`.`class_ID` = class.class_ID
                                                WHERE course.teacher_ID = :id
                                                GROUP BY course.course_ID, class.class_ID, `group`.group_ID, subject.subject_ID", stdClass::class
                                                , [new DbParam("id", $id)]);
        $courseTeacher = array_map(function ($courseInfo) {
            if ($courseInfo->class_name == $courseInfo->group_name) {
                return  ["title" => $courseInfo->class_name . " - " . $courseInfo->name, "id" => $courseInfo->class_ID . "-" . $courseInfo->subject_ID];
            }
            return ["title" => $courseInfo->class_name . " - " . $courseInfo->group_name . " - " . $courseInfo->name, "id" => $courseInfo->class_ID . "-" . $courseInfo->group_ID . "-" . $courseInfo->subject_ID];
        }, $courseTeacher);
        $garant = $this->db->getAll("SELECT class.class_name, class.class_ID, subject.name, subject.subject_ID FROM subject 
                                        JOIN course ON course.subject_ID = subject.subject_ID
                                        JOIN `group` ON course.group_ID = `group`.group_ID
                                        JOIN class ON class.class_ID = `group`.class_ID
                                        WHERE subject.teacher_ID = :id
                                        GROUP BY class.class_name, subject.name"
                                        , stdClass::class, [new DbParam("id",$id)]);
        if ($garant) {
            $garant = array_map(function ($class) {
                return ["title" => $class->class_name . " - " . $class->name, "id" => $class->class_ID . "-" . $class->subject_ID ];
            }, $garant);
        }

        return ["classTeacher" => $classTeacher, "courseTeacher" => $courseTeacher, "garant" => $garant];
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

    public function checkIfTeacher(string $id): bool
    {
        $sql = "SELECT * FROM teacher WHERE teacher_ID = :id";
        return (bool)$this->db->getValue($sql, [new DbParam("id", $id)]);
    }


}