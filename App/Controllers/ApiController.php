<?php

namespace App\Controllers;

use App\Models\Files\FilesFacade;
use App\Models\Mark\MarkFacade;
use App\Session;
use FilesystemIterator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class ApiController extends AController
{

    private array $debug;

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


    // ----------------- FILES ------------------- \\


    /*
    [file] => 1
    [back] => ''
     */
    public function getFile(): void
    {
        $fileFacade = new FilesFacade();

        $info = $fileFacade->getFileInfo($_POST["file"]);
        $this->sendFile($info["path"], $info["name"]);

        $this->redirectURL($_POST["backURL"]);
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

            $zip = new ZipArchive();
            $zip->open("file.zip", ZIPARCHIVE::CREATE);

            if (isset($_POST["folder"])) {
                foreach ($_POST["folder"] as $folder) {
                    if ($fileFacade->checkFolderPrivate($folder, Session::get("user_ID"))) {
                        $zip = $this->Zip($zip, getCfgVar("storage") . $fileFacade->getFolderInfo($folder)["path"]);
                    }
                }
            }

            if (isset($_POST["file"])) {
                foreach ($_POST["file"] as $file) {
                    $zip = $this->Zip($zip, getCfgVar("storage") . $fileFacade->getFileInfo($file)["path"]);
                }
            }

            $zip->close();

            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=file.zip');
            header('Content-Length: ' . filesize("file.zip"));
            readfile("file.zip");
            unlink("file.zip");
        } else {
            $this->redirectURL($_POST["backURL"]);
        }

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

        if ($_POST["parent"]) {
            $info = $fileFacade->getFolderInfo($_POST["parent"]);
            $folder = $fileFacade->createFolder($_POST["parent"], $_POST["name"], Session::get("user_ID"), $info["private"] === 1 ? 1 : isset($_POST["parent"]));
        } else {
            $folder = $fileFacade->createFolder($_POST["parent"], $_POST["name"], Session::get("user_ID"), isset($_POST["private"]));
        }
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

        if (isset($_POST["file"])) {
            foreach ($_POST["file"] as $file) {
                if ($fileFacade->checkFileAccess($file, Session::get("user_ID"))) {
                    $fileInfo = $fileFacade->getFileInfo($file);
                    unlink(getCfgVar("storage") . $fileInfo["path"]);

                    $fileFacade->removeFile($file, Session::get("user_ID"));
                }
            }
        }


        if (isset($_POST["folder"])) {
            foreach ($_POST["folder"] as $folder) {
                if ($fileFacade->checkFolderAccess($folder, Session::get("user_ID"))) {
                    $folderInfo = $fileFacade->getFolderInfo($folder);

                    $dir = getCfgVar("storage") . $folderInfo["path"];
                    $it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
                    $files = new RecursiveIteratorIterator($it,
                        RecursiveIteratorIterator::CHILD_FIRST);
                    foreach ($files as $file) {
                        if ($file->isDir()) {
                            rmdir($file->getRealPath());
                        } else {
                            unlink($file->getRealPath());
                        }
                    }
                    rmdir($dir);

                    $fileFacade->removeFolder($folder, Session::get("user_ID"));
                }
            }
        }

        $this->redirectURL($_POST["backURL"]);
    }

    private function sendFile(string $path, string $name): void
    {

        $file = getCfgVar("storage") . $path;
        if (file_exists($file)) {

            //Get file type and set it as Content Type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            header('Content-Type: ' . finfo_file($finfo, $file));
            finfo_close($finfo);

            //Use Content-Disposition: attachment to specify the filename
            header('Content-Disposition: attachment; filename=' . $name);

            //No cache
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');

            //Define file size
            header('Content-Length: ' . filesize($file));

            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }

    private function generateExcel(array $marks): void
    {
        $subjectName = array_shift($marks);

        $alphabet = range('A', 'Z');
        $marksWidth = 1;

        foreach ($marks as $mark) {
            if (count($mark["marks"]) > $marksWidth) $marksWidth = count($mark["marks"]) + 2;
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setTitle($subjectName);
        $sheet = $spreadsheet->getActiveSheet();

        $row = 1;
        foreach ($marks as $name => $markInfo) {
            $sheet->setCellValue($alphabet[0] . $row, $name);

            for ($i = 0; $i < $marksWidth; $i++) {
                $sheet->setCellValue($alphabet[$i + 1] . $row, key_exists($i, $markInfo["marks"]) ? $markInfo["marks"][$i] : '');
            }

            $sheet->setCellValue($alphabet[$marksWidth + 1] . $row, $markInfo["averageRounded"]);
            $sheet->setCellValue($alphabet[$marksWidth + 2] . $row, $markInfo["average"]);

            $row++;
        }
        $sheet->getStyle($alphabet[1] . ":" . $alphabet[$marksWidth + 2])->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('A')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode("znamky.xlsx") . '"');
        $writer->save('php://output');
    }

    private function Zip(ZipArchive $zip, string $source): ZipArchive
    {
        $fileFacade = new FilesFacade();
        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source)) {

            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

            $arr = explode("/", $source);
            $maindir = $arr[count($arr) - 1];

            $source = "";
            for ($i = 0; $i < count($arr) - 1; $i++) {
                $source .= '/' . $arr[$i];
            }

            $source = substr($source, 1);

            $zip->addEmptyDir($maindir);

            foreach ($files as $file) {
                $file = str_replace('\\', '/', $file);

                // Ignore "." and ".." folders
                if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
                    continue;

                $file = realpath($file);

                $file = str_replace('\\', '/', $file);
                $source = str_replace('\\', '/', $source);

                if (is_dir($file)) {
                    $temp = explode("/", $file);
                    $temp = array_pop($temp);
                    $temp = explode("-", $temp)[0];

                    if ($fileFacade->checkFolderPrivate($temp, Session::get("user_ID"))) {
                        $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                    }
                } else if (is_file($file)) {
                    $temp = explode("/", $file);
                    $temp = array_pop($temp);
                    $temp = explode("-", $temp)[0];

                    if ($fileFacade->checkFilePrivate($temp, Session::get("user_ID"))) {
                        $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                    }
                }
            }
        } else if (is_file($source)) {
            $temp = explode("/", $source);
            $temp = array_pop($temp);
            $temp = explode("-", $temp)[0];

            if ($fileFacade->checkFilePrivate($temp, Session::get("user_ID"))) {
                $zip->addFromString(basename($source), file_get_contents($source));
            }
        }

        return $zip;
    }

}