<?php

namespace App\Models\Mark;

use App\Models\DB\Db;
use App\Models\DB\DbParam;

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
        $sql = "SELECT mark_category.label, mark_category.weight, mark_category.color, mark_type.mark, mark.description,
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
        $parsedSlug = explode("-",$slug);
        $type = array_pop($parsedSlug);

        $marks = "";

        if ($type === "classTeacher" || $type === "garant") {
            $classID = $parsedSlug[0];
            $subjectID = $parsedSlug[1];

            $sql = "SELECT mark_category.label, mark_category.weight, mark_category.color, mark_type.mark, mark.description, ucak.first_name as firstName, ucak.last_name as lastName, subject.name as subjectName, mark.latka, mark.date,
                    studak.first_name as student_firstName, studak.last_name as student_lastName
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
            $classID = $parsedSlug[0];
            $groupID = $parsedSlug[1];
            $subjectID = $parsedSlug[2];

            $sql = "SELECT mark_category.label, mark_category.weight, mark_category.color, mark_type.mark, mark.description, ucak.first_name as firstName, ucak.last_name as lastName, subject.name as subjectName, mark.latka, mark.date,
                    studak.first_name as student_firstName, studak.last_name as student_lastName
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

        $students = array_map(function ($mark) {
            return $mark->getStudentsName();
        }, $marks);
        $students = array_unique($students);

        $formattedMarks = [];
        foreach ($students as $student) {
            $formattedMarks[$student] = array_filter($marks, function ($mark) use ($student) {
                return $student === $mark->getStudentsName();
            });
        }
        ksort($formattedMarks);
        return $formattedMarks;
    }
}