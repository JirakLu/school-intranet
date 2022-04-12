<?php

namespace App\Models\Subject;

class SubjectFacade {

    private SubjectRepository $subjectRepo;

    public function __construct()
    {
        $this->subjectRepo = new SubjectRepository();
    }

}
