<?php

namespace App\Models\Teacher;

use App\Models\DB\Db;

class TeacherRepository {

    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

}