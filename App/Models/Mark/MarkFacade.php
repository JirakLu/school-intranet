<?php

namespace App\Models\Mark;

class MarkFacade
{

    private MarkRepository $markRepo;

    public function __construct()
    {
        $this->markRepo = new MarkRepository();
    }

    /** @return array<string, array<int, MarkEntity>>|null */
    public function getMarksForUser(string $id): array|null
    {
        return $this->markRepo->getMarksForUser($id);
    }

    /** @return array<string, array<int, MarkEntity>>|null */
    public function getMarksBySlug(string $slug)
    {
        return $this->markRepo->getMarksBySlug($slug);
    }
}