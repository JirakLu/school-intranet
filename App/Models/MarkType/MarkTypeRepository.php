<?php

namespace App\Models\MarkType;

use App\Models\DB\Db;

class MarkTypeRepository {

    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

}