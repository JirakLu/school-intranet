<?php

namespace App\Models\Group;

use App\Models\Class\ClassEntity;
use App\Models\Course\CourseEntity;
use App\Models\Student\StudentEntity;

class GroupEntity {

    private string $groupID;
    private string $name;
    private ClassEntity $class;
    /** @var StudentEntity[]  */
    private array $student;
    /** @var CourseEntity[]  */
    private array $courses;

}