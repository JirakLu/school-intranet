<?php

namespace App\Controllers;

use DbFiller\DbFiller;

class FillerController extends AController
{
    public function render(): void
    {
        //TODO: Make DB filling GUI
        $filler = new DbFiller();
        $filler->fill();
    }
}