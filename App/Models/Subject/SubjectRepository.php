<?php

namespace App\Models\Subject;

use App\Models\DB\Db;

class SubjectRepository {

    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

}