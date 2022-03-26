<?php

namespace App\Controllers;

class ScheduleController extends AController
{
    public function render(): void
    {
        $this->renderView("pages.public.schedule");
    }
}