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

    public function getTeachingByID(string $userID): array
    {
        $classTeacher = $this->db->getAll("SELECT course.course_ID courseID, c.class_name className, g.name groupName, s.name subjectName
                                                FROM course
                                                JOIN subject s on course.subject_ID = s.subject_ID
                                                JOIN `group` g on course.group_ID = g.group_ID
                                                JOIN class c on g.class_ID = c.class_ID
                                                WHERE c.teacher_ID = :userID
                                                ORDER BY s.name;", stdClass::class, [new DbParam("userID", $userID)]);

        $courseTeacher = $this->db->getAll("SELECT course.course_ID courseID, c.class_name className, g.name groupName, s.name subjectName
                                                FROM course
                                                JOIN subject s on course.subject_ID = s.subject_ID
                                                JOIN `group` g on course.group_ID = g.group_ID
                                                JOIN class c on g.class_ID = c.class_ID
                                                WHERE course.teacher_ID = :userID
                                                ORDER BY s.name", stdClass::class, [new DbParam("userID", $userID)]);


        $garant = $this->db->getAll("SELECT course.course_ID courseID, c.class_name className, g.name groupName, s.name subjectName
                                            FROM course
                                            JOIN subject s on course.subject_ID = s.subject_ID
                                            JOIN `group` g on course.group_ID = g.group_ID
                                            JOIN class c on g.class_ID = c.class_ID
                                            WHERE s.teacher_ID = :userID
                                            ORDER BY s.name"
                                        , stdClass::class, [new DbParam("userID",$userID)]);

        return ["classTeacher" => $this->formatTeachingSelection($classTeacher, "classTeacher"),
                "courseTeacher" => $this->formatTeachingSelection($courseTeacher, "courseTeacher"),
                "garant" => $this->formatTeachingSelection($garant, "garant")];
    }

    private function formatTeachingSelection($selection, string $type): array|null
    {
        if ($selection) {
            $selection = array_map(function($course) use($type) {
                if ($course->className === $course -> groupName) return ["title" => $course->className . " - " . $course->subjectName, "id" => $course->courseID . "-$type"];
                return ["title" => $course->className . " - " . $course->groupName . " - " . $course->subjectName, "id" => $course->courseID . "-$type"];
            }, $selection);
        }

        return $selection;
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

    public function removeAuthCookie(string $userID): void
    {
        $sql = "UPDATE user SET auth_cookie = NULL, cookie_selector = NULL WHERE user_ID = :userID";
        $this->db->exec($sql, [new DbParam("userID", $userID)]);
    }


}