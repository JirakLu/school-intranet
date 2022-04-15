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

    public function checkAccess(string $userID, string $slug)
    {
        return $this->markRepo->checkAccess($userID,$slug);
    }

    public function getMarkCategories(string $userID)
    {
        return $this->markRepo->getMarkCategories($userID);
    }

    public function getMarkTypes()
    {
        return $this->markRepo->getMarkTypes();
    }

    public function addMark(string $date, string $latka, string $description, array $info, string $studentID, string $markCategory, string $markType): void
    {
        $this->markRepo->addMark($date, $latka, $description, $info, $studentID, $markCategory, $markType);
    }

    public function editMark(string $date, string $latka, string $description, string $markID, string $markCategory, string $markType): void
    {
        $this->markRepo->editMark($date, $latka, $description, $markID, $markCategory, $markType);
    }

    public function removeMark(string $markID): void
    {
        $this->markRepo->removeMark($markID);
    }
}