<?php

namespace App\Models\MarkType;

class MarkTypeFacade {

    private MarkTypeRepository $markTypeRepo;

    public function __construct()
    {
        $this->markTypeRepo = new MarkTypeRepository();
    }

}
