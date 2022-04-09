<?php

namespace App\Controllers;

use App\Models\Mark\MarkRepository;
use DbFiller\DbFiller;

class PublicController extends AController
{

    /**
     * Controller for /home
     * @return void
     */
    public function renderHome(): void
    {
        $this->renderView("pages.public.index");
    }

    /**
     * Controller for /teachers
     * @return void
     */
    public function renderTeachers(): void
    {
        $this->renderView("pages.public.teachers");
    }

    /**
     * Controller for /schedule
     * @return void
     */
    public function renderSchedule(): void
    {
        $this->renderView("pages.public.schedule");
    }

    /**
     * Controller for /school
     * @return void
     */
    public function renderSchool(): void
    {
        $this->renderView("pages.public.school");
    }

    /**
     * Controller for /news
     * @return void
     */
    public function renderNews(): void
    {
        $this->renderView("pages.public.news");
    }

    /**
     * Controller for /restricted
     * @return void
     */
    public function renderRestricted(): void
    {
        $this->renderView("pages.public.access-restricted");
    }

    /**
     * Controller for /error404
     * @return void
     */
    public function renderError404(): void
    {
        $this->renderView("pages.public.error404");
    }

    /**
     * Controller for /filler
     * @return void
     */
    public function fillDb(): void
    {
        //TODO: Make DB filling GUI
        print_r("DB is filled!");
        $filler = new DbFiller();
        $filler->fill();
    }


}