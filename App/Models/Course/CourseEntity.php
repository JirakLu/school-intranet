<?php

namespace App\Models\Course;

use App\Models\Group\GroupEntity;
use App\Models\Mark\MarkEntity;
use App\Models\Subject\SubjectEntity;
use App\Models\Teacher\TeacherEntity;

class CourseEntity {

    private string $courseID;
    private SubjectEntity $subject;
    private GroupEntity $group;
    private TeacherEntity $teacher;
    /** @var MarkEntity[]  */
    private array $marks;

}