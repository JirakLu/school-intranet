<?php

namespace App\Models\Class;

use App\Models\Group\GroupEntity;
use App\Models\Student\StudentEntity;
use App\Models\Teacher\TeacherEntity;

class ClassEntity {

    private string $classID;
    private string $className;
    private TeacherEntity $teacher;
    /** @var GroupEntity[]  */
    private array $groups;
    /** @var StudentEntity[]  */
    private array $students;

}