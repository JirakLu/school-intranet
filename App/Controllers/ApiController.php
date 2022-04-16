<?php

namespace App\Controllers;

use App\Models\Mark\MarkFacade;
use App\Session;

class ApiController extends AController
{


    /*
    [markID] => 2052
    [backURL] => http://localhost/school-intranet/marks/33-courseTeacher
    [markCategory] => 4
    [markType] => 5
    [latka] => Test
    [description] => Poznámka
    [date] => 2022-03-08
     */
    public function edit(): void
    {
        $this->privateRoute();

        $markFacade = new MarkFacade();
        if (!$markFacade->checkAccessMarkID(Session::get("user_ID"), $_POST["markID"])) $this->redirect("restricted");

        $markFacade->editMark($_POST["markID"], $_POST["date"], $_POST["latka"], $_POST["description"], $_POST["markCategory"], $_POST["markType"]);

        $this->redirectURL($_POST["backURL"]);
    }

    /*
    [markID] => 2128
    [backURL] => http://localhost/school-intranet/marks/33-courseTeacher
     */
    public function delete(): void
    {
        $this->privateRoute();

        $markFacade = new MarkFacade();
        if (!$markFacade->checkAccessMarkID(Session::get("user_ID"), $_POST["markID"])) $this->redirect("restricted");

        $markFacade->removeMark($_POST["markID"]);

        $this->redirectURL($_POST["backURL"]);
    }

    /*
    [studentID] => 27
    [courseID] => 33
    [backURL] => http://localhost/school-intranet/marks/33-courseTeacher
    [markCategory] => 4
    [markType] => 5
    [latka] => Testovací látka
    [description] => Supr poznámka od Černocha.
    [date] => 2022-04-15
     */
    public function add(): void
    {
        $this->privateRoute();

        $markFacade = new MarkFacade();
        if (!$markFacade->checkAccessCourseID(Session::get("user_ID"), $_POST["courseID"])) $this->redirect("restricted");

        $markFacade->addMark($_POST["date"], $_POST["latka"], $_POST["description"], $_POST["courseID"], $_POST["studentID"], $_POST["markCategory"], $_POST["markType"]);

        $this->redirectURL($_POST["backURL"]);
    }

    /*
    [courseID] => 17
    [backURL] => http://localhost/school-intranet/marks/17-courseTeacher
    [markCategory] => 1
    [markType] => 1
    [latka] => Test
    [description] => Test
    [date] => 2022-04-16
     */
    public function addToAll(): void
    {
        $this->privateRoute();

        $markFacade = new MarkFacade();
        if (!$markFacade->checkAccessCourseID(Session::get("user_ID"), $_POST["courseID"])) $this->redirect("restricted");

        $markFacade->addMarkToAll($_POST["date"], $_POST["latka"], $_POST["description"], $_POST["courseID"], $_POST["markCategory"], $_POST["markType"]);

        $this->redirectURL($_POST["backURL"]);
    }

    /*
    [backURL] => http://localhost/school-intranet/marks/34-courseTeacher
    [weight] => 0
    [color] => #547356
    [label] => Oznamovač testů.
     */
    public function addCategory(): void
    {
        $this->privateRoute();

        $markFacade = new MarkFacade();

        $markFacade->addCategory(Session::get("user_ID"), $_POST["weight"], $_POST["color"], $_POST["label"]);

        $this->redirectURL($_POST["backURL"]);
    }

}