<?php

namespace App\Models\Group;

class GroupFacade {

    private GroupRepository $groupRepo;

    public function __construct()
    {
        $this->groupRepo = new GroupRepository();
    }

}
