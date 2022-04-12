<?php

namespace App\Models\Class;

class ClassFacade {

    private ClassRepository $classRepo;

    public function __construct()
    {
        $this->classRepo = new ClassRepository();
    }

}
