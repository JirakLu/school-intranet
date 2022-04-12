<?php

namespace App\Models\MarkCategory;

use App\Models\Teacher\TeacherEntity;

class MarkCategoryEntity {

    private string $categoryID;
    private string $label;
    private int $weight;
    private string $color;
    private TeacherEntity $teacher;

}