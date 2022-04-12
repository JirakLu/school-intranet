<?php

namespace App\Models\MarkCategory;

class MarkCategoryFacade {

    private MarkCategoryRepository $markCategoryRepo;

    public function __construct()
    {
        $this->markCategoryRepo = new MarkCategoryRepository();
    }

}
