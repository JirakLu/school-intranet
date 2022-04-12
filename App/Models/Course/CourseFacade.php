<?php

namespace App\Models\Course;

class CourseFacade {

    private CourseRepository $courseRepo;

    public function __construct()
    {
        $this->courseRepo = new CourseRepository();
    }

}
