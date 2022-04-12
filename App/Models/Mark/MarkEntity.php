<?php

namespace App\Models\Mark;

use App\Models\Course\CourseEntity;
use App\Models\MarkCategory\MarkCategoryEntity;
use App\Models\MarkType\MarkTypeEntity;
use App\Models\Student\StudentEntity;

class MarkEntity {

    private string $markID;
    private string $date;
    private string $latka;
    private string $description;
    private CourseEntity $course;
    private StudentEntity $student;
    private MarkCategoryEntity $markCategory;
    private MarkTypeEntity $markType;


}