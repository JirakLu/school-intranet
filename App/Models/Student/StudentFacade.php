<?php

namespace App\Models\Student;

class StudentFacade {

    private StudentRepository $studentRepo;

    public function __construct()
    {
        $this->studentRepo = new StudentRepository();
    }

}
