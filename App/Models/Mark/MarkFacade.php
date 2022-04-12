<?php

namespace App\Models\Mark;

class MarkFacade {

    private MarkRepository $markRepo;

    public function __construct()
    {
        $this->markRepo = new MarkRepository();
    }

}
