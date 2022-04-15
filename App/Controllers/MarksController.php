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

            $this->renderAuth("pages.private.marksTeacher", "restricted", Session::get("isLoggedIn"), ["form" => $teachings]);
        } else {
            $markFacade = new MarkFacade();
            $marks = $markFacade->getMarksForUser(Session::get("user_ID"));

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
        
        $selected = "";

        foreach($teachings as $type => $info) {
            $selected = array_filter($info, function ($obj) use ($slug, $type) {
                return $obj["id"] . "-" . $type === $slug ;
            });
            if (!empty($selected)) break;
        }
        $formSelected["id"] = $slug;
        $megalumen = explode("-",$slug);
        $formSelected["type"] = array_pop($megalumen);
        $info = array_pop($selected);
        $formSelected["title"] = $info["title"];

        if ($formSelected["type"] === "courseTeacher") {
            $this->renderAuth("pages.private.marksTeacherEdit", "restricted", Session::get("isLoggedIn"),
                ["form" => $teachings, "selected" => $formSelected, "marks" => $marks]);
        } else {
            $this->renderAuth("pages.private.marksTeacher", "restricted", Session::get("isLoggedIn"),
                ["form" => $teachings, "selected" => $formSelected, "marks" => $marks]);
        }


    }
}