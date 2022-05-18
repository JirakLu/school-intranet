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

    public function getMarkCategories(string $userID, bool $getDefaults)
    {
        return $this->markRepo->getMarkCategories($userID, $getDefaults);
    }

    public function getMarkTypes()
    {
        return $this->markRepo->getMarkTypes();
    }

    public function addMark(string $date, string $latka, string $description, string $courseID, string $studentID, string $markCategoryID, string $markTypeID): void
    {
        $this->markRepo->addMark($date, $latka, $description, $courseID, $studentID, $markCategoryID, $markTypeID);
    }

    public function addMarkToAll(string $date, string $latka, string $description, string $courseID, string $markCategoryID, string $markTypeID): void
    {
        $this->markRepo->addMarkToAll($date, $latka, $description, $courseID, $markCategoryID, $markTypeID);
    }

    public function editMark(string $markID, string $date, string $latka, string $description, string $markCategoryID, string $markTypeID): void
    {
        $this->markRepo->editMark($markID, $date, $latka, $description, $markCategoryID, $markTypeID);
    }

    public function removeMark(string $markID): void
    {
        $this->markRepo->removeMark($markID);
    }

    public function checkAccessMarkID(string $userID, string $markID): bool
    {
        return $this->markRepo->checkAccessMarkID($userID, $markID);
    }

    public function checkAccessCourseID(string $userID, string $courseID): bool
    {
        return $this->markRepo->checkAccessCourseID($userID, $courseID);
    }

    public function addCategory(string $userID, int $weight, string $color, string $label): void
    {
        $this->markRepo->addCategory($userID, $weight, $color, $label);
    }

    public function removeCategory(string $categoryID, string $userID): void {
        $this->markRepo->removeCategory($categoryID, $userID);
    }

    public function exportMarksForTeacher(string $courseID, string $userID): array {
        return $this->markRepo->exportMarksForTeacher($courseID, $userID);
    }

    public function exportMarksForStudent(string $userID): array {
        return $this->markRepo->exportMarksForStudent($userID);
    }
}