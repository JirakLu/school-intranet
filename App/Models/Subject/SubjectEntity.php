<?php

namespace App\Models\Subject;

use App\Models\Teacher\TeacherEntity;

class SubjectEntity {

    private string $subjectID;
    private string $name;
    private string $shortName;
    private TeacherEntity|null $teacher;

}