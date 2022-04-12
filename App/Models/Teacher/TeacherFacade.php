<?php

namespace App\Models\Teacher;

class TeacherFacade {

    private TeacherRepository $teacherRepo;

    public function __construct()
    {
        $this->teacherRepo = new TeacherRepository();
    }

}
