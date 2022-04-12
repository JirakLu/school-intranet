<?php

namespace App\Models\Teacher;

use App\Models\Class\ClassEntity;
use App\Models\Course\CourseEntity;
use App\Models\MarkCategory\MarkCategoryEntity;
use App\Models\Subject\SubjectEntity;
use App\Models\User\UserEntity;

class TeacherEntity {

    private UserEntity $user;
    private bool $admin;
    private ClassEntity|null $class;
    /** @var SubjectEntity[]|SubjectEntity|null  */
    private array|null $subject;
    /** @var MarkCategoryEntity[]  */
    private array $markCategory;
    /** @var CourseEntity[]  */
    private array $courses;

}