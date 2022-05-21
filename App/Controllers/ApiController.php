<?php

namespace App\Controllers;

use App\Models\Files\FilesFacade;
use App\Models\Mark\MarkFacade;
use App\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ZipArchive;

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
        $markFacade = new MarkFacade();

        if ($_POST["courseID"]) {
            // teacher export
            if (!$markFacade->checkAccessCourseID(Session::get("user_ID"), $_POST["courseID"])) $this->redirect("restricted");
            $marks = $markFacade->exportMarksForTeacher($_POST["courseID"], $_POST["userID"]);
            $this->generateExcel($marks);

        } else {
            // student export
            $marks = $markFacade->exportMarksForStudent($_POST["userID"]);
            $this->generateExcel($marks);
        }
    }

    /*
    [file] => 1
    [back] => ''
     */
    public function getFile(): void
    {
        $fileFacade = new FilesFacade();
        $path = $fileFacade->getFilePath($_POST["file"]);

        $this->sendFile($path);
    }

    /*
    [folder] => Array
            [0] => 5
            [1] => 6
    [file] => Array
            [0] => 2
    [backURL] => ''
     */
    public function download(): void
    {
        $fileFacade = new FilesFacade();

        if (isset($_POST["file"]) || isset($_POST["folder"])) {
            $zipname = 'file.zip';
            $zip = new ZipArchive;
            $zip->open($zipname, ZipArchive::CREATE);

            if (isset($_POST["file"])) {
                foreach ($_POST["file"] as $file) {
                    $zip->addFile(getCfgVar("storage") . $fileFacade->getFilePath($file));
                }
            }

            if (isset($_POST["folder"])) {
                foreach ($_POST["folder"] as $folder) {
                    $zip->addFile(getCfgVar("storage") . $fileFacade->getFolderPath($folder));
                }
            }

            $zip->close();

            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename='.$zipname);
            header('Content-Length: ' . filesize($zipname));
            readfile($zipname);
        }

        $this->redirectURL($_POST["backURL"]);
    }

    /*
    [parent] => 2

    [upload] => Array
            [name] => Webovky.txt
            [full_path] => Webovky.txt
            [type] => text/plain
            [tmp_name] => C:\wamp64\tmp\php98F3.tmp
            [error] => 0
            [size] => 0
     */
    public function upload(): void
    {
        $fileFacade = new FilesFacade();
        $path = $fileFacade->addFile($_FILES["upload"]["name"], $_POST["parent"], $_FILES["upload"]["type"]);
        move_uploaded_file($_FILES["upload"]["tmp_name"], getCfgVar("storage") . $path);

        $this->redirectURL($_POST["backURL"]);
    }

    /*
    [parent] => 1 | ''
    [name] => Pepa
    ??[private] => private
    ["backURL"] => ''
     */
    public function createFolder(): void
    {
        $fileFacade = new FilesFacade();
        $folder = $fileFacade->createFolder($_POST["parent"], $_POST["name"], Session::get("user_ID"), isset($_POST["private"]));
        mkdir(getCfgVar("storage") . $folder);

        $this->redirectURL($_POST["backURL"]);
    }

    /*
    [folder] => Array
            [0] => 4
            [1] => 5
            [2] => 6
    [file] => Array
            [0] => 1
            [1] => 2
    [backURL] => ''
     */
    public function deleteFiles(): void
    {
        $fileFacade = new FilesFacade();

        foreach ($_POST["file"] as $file) {
            $fileFacade->removeFile($file, Session::get("user_ID"));
        }

        foreach ($_POST["folder"] as $folder) {
            $fileFacade->removeFolder($folder, Session::get("user_ID"));
        }
    }

    private function sendFile(string $file): void
    {
        $file = getCfgVar("storage") . $file;
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    private function generateExcel(array $marks): void {
        $subjectName = array_shift($marks);

        $alphabet = range('A', 'Z');
        $marksWidth = 1;

        foreach ($marks as $mark) {
            if (count($mark["marks"]) > $marksWidth) $marksWidth = count($mark["marks"] ) + 2;
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
        $sheet->getStyle($alphabet[1] . ":" . $alphabet[$marksWidth+2])->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('A')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode("znamky.xlsx").'"');
        $writer->save('php://output');
    }

}