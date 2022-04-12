<?php

namespace App\Models\Student;

use App\Models\DB\Db;

class StudentRepository {

    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

}