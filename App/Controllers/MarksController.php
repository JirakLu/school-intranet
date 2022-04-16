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

            $this->renderAuth("pages.private.marksTeacher", "restricted", Session::get("isLoggedIn"), ["teachings" => $teachings]);
        } else {
            $markFacade = new MarkFacade();
            $marks = $markFacade->getMarksForStudent(Session::get("user_ID"));

            $this->renderAuth("pages.private.marks", "restricted", Session::get("isLoggedIn"), ["marks" => $marks]);
        }

    }

    public function teacherAccess(string $slug): void
    {
        $markFacade = new MarkFacade();
        if (!$markFacade->checkAccess(Session::get("user_ID"), $slug)) $this->redirect("restricted");

        $userFacade = new UserFacade();
        $teachings = $userFacade->getTeachingByID(Session::get("user_ID"));
        $marks = $markFacade->getMarksBySlug($slug);

        $slug = explode("-",$slug);
        $type = array_pop($slug);
        $courseID = array_shift($slug);

        $selectedTitle = "";
        foreach ($teachings as $teaching) {
            foreach ($teaching as $teach) {
                if ($teach["id"] === $courseID . "-" . $type) {
                    $selectedTitle = $teach["title"];
                    break;
                }
            }
            if (!empty($selectedTitle)) break;
        }
        
        $selected = [
            "id" => $courseID . "-" . $type,
            "type" => $type,
            "title" => $selectedTitle
        ];

        if ($selected["type"] === "courseTeacher") {
            $this->renderAuth("pages.private.marksTeacherEdit", "restricted", Session::get("isLoggedIn"),
                ["teachings" => $teachings, "selected" => $selected, "marks" => $marks]);
        } else {
            $this->renderAuth("pages.private.marksTeacher", "restricted", Session::get("isLoggedIn"),
                ["teachings" => $teachings, "selected" => $selected, "marks" => $marks]);
        }


    }
}