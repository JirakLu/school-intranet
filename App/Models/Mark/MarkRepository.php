<?php

namespace App\Models\Mark;

use App\Models\DB\Db;

class MarkRepository {

    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

}