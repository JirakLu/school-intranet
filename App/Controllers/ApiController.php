<?php

namespace App\Controllers;

use App\Models\Mark\MarkFacade;
use App\Session;

class ApiController extends AController
{

    //TODO: Check AUTH everywhere
    //TODO: Check inputs everywhere

    /*
    [markID] => 92
    [backURL] => http://localhost/school-intranet/marks/1-1-courseTeacher
    [markCategory] => 1
    [markType] => 3
    [latka] => Multimateriál
    [description] => 1+(3+1+3+3uv-½uv)+(1+6+2+4uv)+(1+6+2+4uv) = 36,5 ~ 96 %
    [date] => 2022-03-07
     */
    public function edit(): void
    {
        $this->privateRoute();


        $markFacade = new MarkFacade();
        $markFacade->editMark($_POST["date"], $_POST["latka"], $_POST["description"], $_POST["markID"], $_POST["markCategory"], $_POST["markType"]);

        $this->redirectURL($_POST["backURL"]);
    }

    /*
    [markID] => 94
    [backURL] => http://localhost/school-intranet/marks/1-1-courseTeacher
     */
    public function delete(): void
    {
        $this->privateRoute();

        $markFacade = new MarkFacade();
        $markFacade->removeMark($_POST["markID"]);

        $this->redirectURL($_POST["backURL"]);
    }

    /*
    [userID] => 3
    [backURL] => http://localhost/school-intranet/marks/1-1-courseTeacher
    [markCategory] => 1
    [markType] => 1
    [latka] =>
    [description] =>
    [date] =>
     */
    public function add(): void
    {
        $this->privateRoute();

        $courseInfo = explode("/", $_POST["backURL"]);
        $courseInfo = array_pop($courseInfo);
        $courseInfo = explode("-", $courseInfo);
        array_pop($courseInfo);
        $subjectID = array_pop($courseInfo);

        $info = ["classID" => $courseInfo[0], "subjectID" => $subjectID, "teacherID" => Session::get("user_ID")];

        $markFacade = new MarkFacade();
        $markFacade->addMark($_POST["date"], $_POST["latka"], $_POST["description"], $info, $_POST["userID"], $_POST["markCategory"], $_POST["markType"]);

        $this->redirectURL($_POST["backURL"]);
    }

}