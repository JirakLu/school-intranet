<?php

namespace App\Models\Course;

use App\Models\DB\Db;

class CourseRepository {

    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

}