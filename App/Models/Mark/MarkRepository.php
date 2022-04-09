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
        $sql = "SELECT mark_category.label, mark_category.weight, mark_category.color, mark_type.mark, mark_type.description,
                user.first_name as firstName, user.last_name as lastName, subject.name as subjectName, mark.latka, mark.date 
                FROM mark
                JOIN mark_type ON mark.Mark_type_mark_type_ID = mark_type.mark_type_ID 
                JOIN mark_category ON mark.mark_category_ID = mark_category.category_ID
                JOIN course ON mark.course_ID = course.course_ID
                JOIN subject ON course.course_ID = subject.subject_ID
                JOIN user ON course.teacher_ID = user.user_ID
                WHERE mark.student_ID = :studentID
                GROUP BY mark.course_ID, mark_category.category_ID, mark_type.mark_type_ID, user.user_ID, subject.subject_ID";

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
}