<?php

namespace App\Models\Mark;

class MarkEntity
{

    private string $label;
    private int $weight;
    private string $color;
    private string $mark;
    private string $markID;
    private string $description;
    private string $firstName;
    private string $lastName;
    private string $subjectName;
    private string $latka;
    private string $date;
    private string|null $studentID;
    private string $categoryID;
    private string|null $student_firstName;
    private string|null $student_lastName;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getMark(): string
    {
        return $this->mark;
    }

    /**
     * @param string $mark
     */
    public function setMark(string $mark): void
    {
        $this->mark = $mark;
    }

    /**
     * @return string
     */
    public function getMarkID(): string
    {
        return $this->markID;
    }

    /**
     * @param string $markID
     */
    public function setMarkID(string $markID): void
    {
        $this->markID = $markID;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getSubjectName(): string
    {
        return $this->subjectName;
    }

    /**
     * @param string $subjectName
     */
    public function setSubjectName(string $subjectName): void
    {
        $this->subjectName = $subjectName;
    }

    /**
     * @return string
     */
    public function getLatka(): string
    {
        return $this->latka;
    }

    /**
     * @param string $latka
     */
    public function setLatka(string $latka): void
    {
        $this->latka = $latka;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string|null
     */
    public function getStudentID(): ?string
    {
        return $this->studentID;
    }

    /**
     * @param string|null $studentID
     */
    public function setStudentID(?string $studentID): void
    {
        $this->studentID = $studentID;
    }

    /**
     * @return string
     */
    public function getCategoryID(): string
    {
        return $this->categoryID;
    }

    /**
     * @param string $categoryID
     */
    public function setCategoryID(string $categoryID): void
    {
        $this->categoryID = $categoryID;
    }

    /**
     * @return string|null
     */
    public function getStudentFirstName(): ?string
    {
        return $this->student_firstName;
    }

    /**
     * @param string|null $student_firstName
     */
    public function setStudentFirstName(?string $student_firstName): void
    {
        $this->student_firstName = $student_firstName;
    }

    /**
     * @return string|null
     */
    public function getStudentLastName(): ?string
    {
        return $this->student_lastName;
    }

    /**
     * @param string|null $student_lastName
     */
    public function setStudentLastName(?string $student_lastName): void
    {
        $this->student_lastName = $student_lastName;
    }

    public function getStudentsName(): string
    {
        return $this->student_firstName . " " . $this->student_lastName;
    }

    public function getTeachersName(): string
    {
        return $this->firstName . " " . $this->lastName;
    }


}