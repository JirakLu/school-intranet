<?php

namespace App\Models\Mark;

use App\Models\DB\Db;
use App\Models\DB\DbParam;
use stdClass;

class MarkRepository
{

    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }


    public function getMarksForStudent(string $studentID): array|null
    {
        $sql = "SELECT mark.mark_ID markID, mark.date, mark.latka, mark.description markDesc, mark.course_ID courseID, mark.student_ID studentID, mark.mark_category_ID markCategoryID, mark.mark_type_ID markTypeID,
                mc.label mcLabel, mc.weight mcWeight, mc.color mcColor,
                mt.mark mtMark, mt.description mtDesc,
                s.subject_ID subjectID, s.name subjectName,
                ucak.first_name teacherName, ucak.last_name teacherSurname,
                studak.first_name studentName, studak.last_name studentSurname
                FROM mark
                JOIN mark_category mc on mark.mark_category_ID = mc.category_ID
                JOIN mark_type mt on mark.mark_type_ID = mt.mark_type_ID
                JOIN course c on c.course_ID = mark.course_ID
                JOIN subject s on c.subject_ID = s.subject_ID
                LEFT JOIN user studak ON student_ID = studak.user_ID
                LEFT JOIN user ucak ON c.teacher_ID = ucak.user_ID
                WHERE student_ID = :studentID
                ORDER BY date";

        /** @var  $marks MarkEntity[] */
        $marks = $this->db->getAll($sql, MarkEntity::class, [new DbParam("studentID", $studentID)]);

        $subjects = $this->db->getAll("SELECT subject.subject_ID, subject.name
                                            FROM subject
                                            JOIN course c on subject.subject_ID = c.subject_ID
                                            JOIN `group` g on c.group_ID = g.group_ID
                                            JOIN student_in_group sig on g.group_ID = sig.group_ID
                                            WHERE sig.student_ID = :studentID", stdClass::class, [new DbParam("studentID", $studentID)]);

        $formattedMarks = [];
        foreach ($subjects as $subject) {
            $markss = array_filter($marks, function ($mark) use ($subject) {
                return $mark->getSubjectID() == $subject->subject_ID;
            });
            $formattedMarks[$subject->subject_ID] = [
                "subjectID" => $subject->subject_ID,
                "subjectName" => $subject->name,
                "average" => calculateAverage($markss, 2),
                "averageRounded" => calculateAverage($markss, 0),
                "marks" => $markss,
            ];
        }

        return $formattedMarks;
    }

    public function getMarksBySlug(string $slug)
    {
        $parsedSlug = explode("-", $slug);
        $courseID = array_shift($parsedSlug);

        $sql = "SELECT mark_category.label, mark_category.weight, mark.mark_ID as markID, mark_category.color, mark.mark_category_ID as categoryID, mark_type.mark, mark.description, ucak.first_name as firstName, ucak.last_name as lastName, subject.name as subjectName, mark.latka, mark.date,
                    studak.first_name as student_firstName, studak.last_name as student_lastName, studak.user_ID as studentID
                    FROM mark
                    JOIN mark_type ON mark.mark_type_ID = mark_type.mark_type_ID 
                    JOIN mark_category ON mark.mark_category_ID = mark_category.category_ID
                    JOIN course ON mark.course_ID = course.course_ID
                    JOIN subject ON course.subject_ID = subject.subject_ID
                    JOIN `group` ON course.group_ID = `group`.group_ID
                    JOIN student ON mark.student_ID = student.student_ID
                    LEFT JOIN user AS ucak ON course.teacher_ID = ucak.user_ID
                    LEFT JOIN user AS studak ON mark.student_ID = studak.user_ID
                    WHERE course.course_ID = :courseID
                    GROUP BY mark.course_ID ,mark.date, mark_category.category_ID, mark_type.mark_type_ID,subject.subject_ID, studak.user_ID, ucak.user_ID
                    ORDER BY mark.date";

        /** @var  $marks MarkEntity[] */
        $marks = $this->db->getAll($sql, MarkEntity::class, [new DbParam("courseID", $courseID)]);

        $students = $this->db->getAll("SELECT user.user_ID userID, user.first_name firstName, user.last_name lastName 
                                            FROM user
                                            JOIN student_in_group sg ON user.user_ID = sg.student_ID
                                            JOIN `group` g on sg.group_ID = g.group_ID
                                            JOIN course c on g.group_ID = c.group_ID
                                            WHERE c.course_ID = :courseID", stdClass::class, [new DbParam("courseID", $courseID)]);

        $formattedMarks = [];
        foreach ($students as $student) {
            $markss = array_filter($marks, function ($mark) use ($student) {
                return $mark->getStudentID() == $student->userID;
            });
            $formattedMarks[$student->userID] = [
                "studentID" => $student->userID,
                "studentName" => $student->firstName . " " . $student->lastName,
                "courseID" => $courseID,
                "marks" => $markss
            ];
        }

        return $formattedMarks;
    }

    public function checkAccess(string $userID, string $slug): bool
    {
        $parsedSlug = explode("-", $slug);

        $type = array_pop($parsedSlug);
        $courseID = array_shift($parsedSlug);

        if ($type === "classTeacher") {
            $sql = "SELECT count(*) FROM course
                    JOIN `group` g on course.group_ID = g.group_ID
                    JOIN class c on g.class_ID = c.class_ID
                    WHERE c.teacher_ID = :userID AND course_ID = :courseID";

            return $this->db->getValue($sql, [new DbParam("userID", $userID), new DbParam("courseID", $courseID)]);
        }

        if ($type === "courseTeacher") {
            $sql = "SELECT count(*) FROM course
                    WHERE teacher_ID = :userID AND course_ID = :courseID";

            return $this->db->getValue($sql, [new DbParam("userID", $userID), new DbParam("courseID", $courseID)]);
        }

        if ($type === "garant") {
            $sql = "SELECT count(*) FROM course
                    JOIN subject s on course.subject_ID = s.subject_ID
                    WHERE s.teacher_ID = :userID AND course.course_ID = :courseID";

            return $this->db->getValue($sql, [new DbParam("userID", $userID), new DbParam("courseID", $courseID)]);
        }

        return false;
    }

    public function getMarkCategories(string $userID)
    {
        $sql = "SELECT category_ID, label, weight, color FROM mark_category WHERE teacher_ID is null || teacher_ID = :teacherID";
        $categories = $this->db->getAll($sql, stdClass::class, [new DbParam("teacherID", $userID)]);

        $ids = array_map(function ($category) {
            return $category->category_ID;
        }, $categories);

        sort($ids);
        $formattedCategories = [];
        foreach ($ids as $id) {
            $match = array_filter($categories, function ($category) use ($id) {
                return $category->category_ID === $id;
            });
            $formattedCategories[$id] = array_pop($match);
        }

        return $formattedCategories;
    }

    public function getMarkTypes()
    {
        $sql = "SELECT * FROM mark_type";

        return $this->db->getAll($sql, stdClass::class);
    }

    public function addMark(string $date, string $latka, string $description, array $info, string $studentID, string $markCategory, string $markType): void
    {
        $sql = "SELECT course.course_ID FROM course 
                JOIN `group` g on course.group_ID = g.group_ID
                WHERE class_ID = :classID AND subject_ID = :subjectID AND teacher_ID = :teacherID";

        $courseID = $this->db->getValue($sql, [new DbParam("classID", $info["classID"]), new DbParam("subjectID", $info["subjectID"]), new DbParam("teacherID", $info["teacherID"])]);

        $this->db->exec("INSERT INTO mark SET date = :date, latka = :latka, description = :desc,
                            course_ID = :courseID, student_ID = :studentID, mark_category_ID = :markCategory, mark_type_ID = :markType",
            [new DbParam("date", $date), new DbParam("latka", $latka), new DbParam("desc", $description), new DbParam("courseID", $courseID)
                , new DbParam("studentID", $studentID), new DbParam("markCategory", $markCategory), new DbParam("markType", $markType)]);

    }

    public function editMark(string $date, string $latka, string $description, string $markID, string $markCategory, string $markType): void
    {
        $this->db->exec("UPDATE mark SET date = :date, latka = :latka, description = :desc, mark_category_ID = :markCategory, mark_type_ID = :markType
                            WHERE mark_ID = :markID",
            [new DbParam("date", $date), new DbParam("latka", $latka), new DbParam("desc", $description),
                new DbParam("markID", $markID), new DbParam("markCategory", $markCategory), new DbParam("markType", $markType)]);
    }

    public function removeMark(string $markID): void
    {
        $this->db->exec("DELETE FROM mark WHERE mark_ID = :markID", [new DbParam("markID", $markID)]);
    }
}