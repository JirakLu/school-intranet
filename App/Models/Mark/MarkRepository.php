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

    /**
     * @param string $id
     * @return array<string, array<int, MarkEntity>>|null
     */
    public function getMarksForUser(string $id): array|null
    {
        $sql = "SELECT mark_category.label, mark_category.weight, mark.mark_ID as markID, mark_category.color, mark.mark_category_ID as categoryID, mark_type.mark, mark.description,
                user.first_name as firstName, user.last_name as lastName, subject.name as subjectName, mark.latka, mark.date
                FROM mark
                JOIN mark_type ON mark.mark_type_ID = mark_type.mark_type_ID 
                JOIN mark_category ON mark.mark_category_ID = mark_category.category_ID
                JOIN course ON mark.course_ID = course.course_ID
                JOIN subject ON course.subject_ID = subject.subject_ID
                JOIN user ON course.teacher_ID = user.user_ID
                WHERE mark.student_ID = :studentID
                GROUP BY mark.course_ID ,mark.date, mark_category.category_ID, mark_type.mark_type_ID, user.user_ID, subject.subject_ID
                ORDER BY mark.date";

        $marks = $this->db->getAll($sql, MarkEntity::class, [new DbParam("studentID", $id)]);

        $subjects = array_map(function ($mark) {
            return $mark->getSubjectName();
        }, $marks);
        $subjects = array_unique($subjects);

        $formattedMarks = [];
        foreach ($subjects as $subject) {
            $formattedMarks[$subject] = array_filter($marks, function ($mark) use ($subject) {
                return $subject === $mark->getSubjectName();
            });
        }

        return $formattedMarks;
    }

    public function getMarksBySlug(string $slug)
    {
        $parsedSlug = explode("-", $slug);
        $type = array_pop($parsedSlug);

        $marks = "";

        if ($type === "classTeacher" || $type === "garant") {
            $classID = $parsedSlug[0];
            $subjectID = $parsedSlug[1];

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
                    WHERE course.subject_ID = :subID AND student.class_ID = :classID 
                    GROUP BY mark.course_ID ,mark.date, mark_category.category_ID, mark_type.mark_type_ID,subject.subject_ID, studak.user_ID, ucak.user_ID
                    ORDER BY mark.date";
            $marks = $this->db->getAll($sql, MarkEntity::class, [new DbParam("subID", $subjectID), new DbParam("classID", $classID)]);

        } elseif ($type === "courseTeacher") {
            if (count($parsedSlug) === 2) {
                $classID = $parsedSlug[0];
                $subjectID = $parsedSlug[1];

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
                    WHERE course.subject_ID = :subjectID AND student.class_ID = :classID
                    GROUP BY mark.course_ID ,mark.date, mark_category.category_ID, mark_type.mark_type_ID,subject.subject_ID, studak.user_ID, ucak.user_ID
                    ORDER BY mark.date";

                $marks = $this->db->getAll($sql, MarkEntity::class, [new DbParam("subjectID", $subjectID), new DbParam("classID", $classID)]);

            } elseif (count($parsedSlug) === 3) {
                $classID = $parsedSlug[0];
                $groupID = $parsedSlug[1];
                $subjectID = $parsedSlug[2];

                $sql = "SELECT mark_category.label, mark_category.weight, mark.mark_ID as markID, mark.mark_category_ID as categoryID, mark_category.color, mark_type.mark, mark.description, ucak.first_name as firstName, ucak.last_name as lastName, subject.name as subjectName, mark.latka, mark.date,
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
                    WHERE course.subject_ID = :subjectID AND student.class_ID = :classID AND `group`.group_ID = :groupID
                    GROUP BY mark.course_ID ,mark.date, mark_category.category_ID, mark_type.mark_type_ID,subject.subject_ID, studak.user_ID, ucak.user_ID
                    ORDER BY mark.date";

                $marks = $this->db->getAll($sql, MarkEntity::class, [new DbParam("subjectID", $subjectID), new DbParam("classID", $classID), new DbParam("groupID", $groupID)]);
            }

        }

        $students = array_map(function ($mark) {
            return $mark->getStudentsName() . "-" . $mark->getStudentID();
        }, $marks);
        $students = array_unique($students);

        $formattedMarks = [];
        foreach ($students as $student) {
            $studentID = explode("-", $student);
            $studentID = array_pop($studentID);
            $formattedMarks[$student] = array_filter($marks, function ($mark) use ($studentID) {
                return $studentID === $mark->getStudentID();
            });
        }
        ksort($formattedMarks);
        return $formattedMarks;
    }

    public function checkAccess(string $userID, string $slug): bool
    {
        $parsedSlug = explode("-", $slug);
        $type = array_pop($parsedSlug);

        if ($type === "classTeacher") {
            $sql = "SELECT count(*) FROM class WHERE teacher_ID = :teacherID";
            return $this->db->getValue($sql, [new DbParam("teacherID", $userID)]);
        } else if ($type === "courseTeacher") {
            if (count($parsedSlug) === 2) {
                $classID = $parsedSlug[0];
                $subjectID = $parsedSlug[1];

                $sql = "SELECT count(*) FROM course 
                        JOIN `group` ON course.group_ID = `group`.group_ID
                        JOIN class  on `group`.class_ID = class.class_ID
                        WHERE course.teacher_ID = :teacherID AND class.class_ID = :classID AND subject_ID = :subjectID";

                return $this->db->getValue($sql, [new DbParam("teacherID", $userID), new DbParam("classID", $classID), new DbParam("subjectID", $subjectID)]);


            } elseif (count($parsedSlug) === 3) {
                $classID = $parsedSlug[0];
                $groupID = $parsedSlug[1];
                $subjectID = $parsedSlug[2];

                $sql = "SELECT count(*) FROM course 
                        JOIN `group` ON course.group_ID = `group`.group_ID
                        JOIN class  on `group`.class_ID = class.class_ID
                        WHERE course.teacher_ID = :teacherID AND class.class_ID = :classID AND subject_ID = :subjectID AND `group`.group_ID = :groupID";

                return $this->db->getValue($sql, [new DbParam("teacherID", $userID), new DbParam("classID", $classID), new DbParam("subjectID", $subjectID), new DbParam("groupID", $groupID)]);
            }
        } elseif ($type === "garant") {
            $subjectID = $parsedSlug[1];

            $sql = "SELECT count(*) FROM subject WHERE subject_ID = :subjectID AND teacher_ID = :teacherID";
            return $this->db->getValue($sql, [new DbParam("teacherID", $userID), new DbParam("subjectID", $subjectID)]);
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