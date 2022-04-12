<?php

namespace App\Models\MarkCategory;

use App\Models\DB\Db;

class MarkCategoryRepository {

    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

}