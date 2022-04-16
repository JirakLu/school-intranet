<?php

namespace App\Models\Mark;

class MarkEntity
{

    /* MARK */
    private string $markID;
    private string $date;
    private string $latka;
    private string $markDesc;
    private string $courseID;
    private string $markCategoryID;
    private string $markTypeID;

    /* Mark Category */
    private string $mcLabel;
    private int $mcWeight;
    private string $mcColor;

    /* Mark Type */
    private string $mtMark;
    private string $mtDesc;

    /* Subject */
    private string $subjectID;
    private string $subjectName;

    /* Teacher */
    private string $teacherID;
    private string $teacherName;
    private string $teacherSurname;

    /* Student */
    private string $studentID;
    private string $studentName;
    private string $studentSurname;

    /* Custom methods */

    public function getTeachersName(): string
    {
        return $this->teacherName . " " . $this->teacherSurname;
    }

    public function getStudentsName(): string
    {
        return $this->studentName . " " . $this->studentSurname;
    }

    /* Generated methods */

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
    public function getMarkDesc(): string
    {
        return $this->markDesc;
    }

    /**
     * @param string $markDesc
     */
    public function setMarkDesc(string $markDesc): void
    {
        $this->markDesc = $markDesc;
    }

    /**
     * @return string
     */
    public function getCourseID(): string
    {
        return $this->courseID;
    }

    /**
     * @param string $courseID
     */
    public function setCourseID(string $courseID): void
    {
        $this->courseID = $courseID;
    }

    /**
     * @return string
     */
    public function getMarkCategoryID(): string
    {
        return $this->markCategoryID;
    }

    /**
     * @param string $markCategoryID
     */
    public function setMarkCategoryID(string $markCategoryID): void
    {
        $this->markCategoryID = $markCategoryID;
    }

    /**
     * @return string
     */
    public function getMarkTypeID(): string
    {
        return $this->markTypeID;
    }

    /**
     * @param string $markTypeID
     */
    public function setMarkTypeID(string $markTypeID): void
    {
        $this->markTypeID = $markTypeID;
    }

    /**
     * @return string
     */
    public function getMcLabel(): string
    {
        return $this->mcLabel;
    }

    /**
     * @param string $mcLabel
     */
    public function setMcLabel(string $mcLabel): void
    {
        $this->mcLabel = $mcLabel;
    }

    /**
     * @return int
     */
    public function getMcWeight(): int
    {
        return $this->mcWeight;
    }

    /**
     * @param int $mcWeight
     */
    public function setMcWeight(int $mcWeight): void
    {
        $this->mcWeight = $mcWeight;
    }

    /**
     * @return string
     */
    public function getMcColor(): string
    {
        return $this->mcColor;
    }

    /**
     * @param string $mcColor
     */
    public function setMcColor(string $mcColor): void
    {
        $this->mcColor = $mcColor;
    }

    /**
     * @return string
     */
    public function getMtMark(): string
    {
        return $this->mtMark;
    }

    /**
     * @param string $mtMark
     */
    public function setMtMark(string $mtMark): void
    {
        $this->mtMark = $mtMark;
    }

    /**
     * @return string
     */
    public function getMtDesc(): string
    {
        return $this->mtDesc;
    }

    /**
     * @param string $mtDesc
     */
    public function setMtDesc(string $mtDesc): void
    {
        $this->mtDesc = $mtDesc;
    }

    /**
     * @return string
     */
    public function getSubjectID(): string
    {
        return $this->subjectID;
    }

    /**
     * @param string $subjectID
     */
    public function setSubjectID(string $subjectID): void
    {
        $this->subjectID = $subjectID;
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
    public function getTeacherID(): string
    {
        return $this->teacherID;
    }

    /**
     * @param string $teacherID
     */
    public function setTeacherID(string $teacherID): void
    {
        $this->teacherID = $teacherID;
    }

    /**
     * @return string
     */
    public function getTeacherName(): string
    {
        return $this->teacherName;
    }

    /**
     * @param string $teacherName
     */
    public function setTeacherName(string $teacherName): void
    {
        $this->teacherName = $teacherName;
    }

    /**
     * @return string
     */
    public function getTeacherSurname(): string
    {
        return $this->teacherSurname;
    }

    /**
     * @param string $teacherSurname
     */
    public function setTeacherSurname(string $teacherSurname): void
    {
        $this->teacherSurname = $teacherSurname;
    }

    /**
     * @return string
     */
    public function getStudentID(): string
    {
        return $this->studentID;
    }

    /**
     * @param string $studentID
     */
    public function setStudentID(string $studentID): void
    {
        $this->studentID = $studentID;
    }

    /**
     * @return string
     */
    public function getStudentName(): string
    {
        return $this->studentName;
    }

    /**
     * @param string $studentName
     */
    public function setStudentName(string $studentName): void
    {
        $this->studentName = $studentName;
    }

    /**
     * @return string
     */
    public function getStudentSurname(): string
    {
        return $this->studentSurname;
    }

    /**
     * @param string $studentSurname
     */
    public function setStudentSurname(string $studentSurname): void
    {
        $this->studentSurname = $studentSurname;
    }




}