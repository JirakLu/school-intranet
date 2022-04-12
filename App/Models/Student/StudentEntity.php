<?php

namespace App\Models\Student;

use App\Models\Class\ClassEntity;
use App\Models\Group\GroupEntity;
use App\Models\Mark\MarkEntity;
use App\Models\User\UserEntity;

class StudentEntity {

    private UserEntity $user;
    private ClassEntity $class;
    /** @var GroupEntity[]  */
    private array $groups;
    /** @var MarkEntity[]  */
    private array $marks;

}