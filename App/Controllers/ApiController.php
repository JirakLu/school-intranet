<?php

namespace App\Controllers;

use App\Models\Mark\MarkFacade;
use App\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

    /*
    [backURL] => http://localhost/school-intranet/marks/34-courseTeacher
    [categoryID] => 5
     */
    public function removeCategory(): void
    {
        $this->privateRoute();

        $markFacade = new MarkFacade();

        $markFacade->removeCategory($_POST["categoryID"], Session::get("user_ID"));

        $this->redirectURL($_POST["backURL"]);
    }

    /*
    [courseID] => 55 || empty
    [userID] => 112
    [backURL] => http://localhost/school-intranet/marks/55-garant
     */
    public function export(): void
    {
        if ($_POST["courseID"]) {
            // teacher export
            $markFacade = new MarkFacade();
            $marks = $markFacade->exportMarksForTeacher($_POST["courseID"], $_POST["userID"]);

            $subjectName = array_shift($marks);

            $alphabet = range('A', 'Z');
            $marksWidth = 1;

            foreach ($marks as $mark) {
                if (count($mark["marks"]) > $marksWidth) $marksWidth = count($mark["marks"] ) + 1;
            }

            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()->setTitle($subjectName);
            $sheet = $spreadsheet->getActiveSheet();

            $row = 1;
            foreach ($marks as $name => $markInfo) {
                $sheet->setCellValue($alphabet[0].$row, $name);

                for ($i = 0; $i < $marksWidth; $i++) {
                    $sheet->setCellValue($alphabet[$i+1].$row, key_exists($i ,$markInfo["marks"]) ? $markInfo["marks"][$i] : '');
                }

                $sheet->setCellValue($alphabet[$marksWidth+1].$row, $markInfo["averageRounded"]);
                $sheet->setCellValue($alphabet[$marksWidth+2].$row, $markInfo["average"]);

                $row++;
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode("znamky.xlsx").'"');
            $writer->save('php://output');

        } else {
            // student export

        }
    }

}