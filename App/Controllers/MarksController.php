<?php

namespace App\Controllers;

use App\Models\Mark\MarkFacade;
use App\Models\User\UserFacade;
use App\Session;

class MarksController extends AController
{
    public function render(): void
    {
        $this->privateRoute();


        if (Session::get("isTeacher")) {
            $userFacade = new UserFacade();
            $teachings = $userFacade->getTeachingByID(Session::get("user_ID"));

//            print("<pre>");
//            print_r($teachings);
//            exit();

            $this->renderAuth("pages.private.marksTeacher", "restricted", Session::get("isLoggedIn"), ["form" => $teachings]);
        } else {
            $markFacade = new MarkFacade();
            $marks = $markFacade->getMarksForUser(Session::get("user_ID"));

            $this->renderAuth("pages.private.marks", "restricted", Session::get("isLoggedIn"), ["marks" => $marks]);
        }

    }

    public function teacherAccess(string $slug): void
    {
        print_r($slug);
    }
}