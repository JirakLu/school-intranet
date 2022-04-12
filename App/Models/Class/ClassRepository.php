<?php

namespace App\Models\Class;

use App\Models\DB\Db;

class ClassRepository {

    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

}