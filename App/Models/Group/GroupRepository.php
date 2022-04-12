<?php

namespace App\Models\Group;

use App\Models\DB\Db;

class GroupRepository {

    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

}