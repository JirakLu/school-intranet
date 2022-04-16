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
    public function getMarksForStudent(string $id): array|null
    {
        return $this->markRepo->getMarksForStudent($id);
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

    public function addMark(string $date, string $latka, string $description, string $courseID, string $studentID, string $markCategoryID, string $markTypeID): void
    {
        $this->markRepo->addMark($date, $latka, $description, $courseID, $studentID, $markCategoryID, $markTypeID);
    }

    public function editMark(string $markID, string $date, string $latka, string $description, string $markCategoryID, string $markTypeID): void
    {
        $this->markRepo->editMark($markID, $date, $latka, $description, $markCategoryID, $markTypeID);
    }

    public function removeMark(string $markID): void
    {
        $this->markRepo->removeMark($markID);
    }
}