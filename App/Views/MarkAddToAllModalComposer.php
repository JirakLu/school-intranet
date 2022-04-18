<?php

namespace App\Views;

use App\Models\Mark\MarkFacade;
use App\Session;
use Illuminate\View\View;


class MarkAddToAllModalComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $markFacade = new MarkFacade();
        $categories = $markFacade->getMarkCategories(Session::get("user_ID"), true);
        $markTypes = $markFacade->getMarkTypes();
        $view->with("categories", $categories);
        $view->with("markTypes", $markTypes);
    }
}