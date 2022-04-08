<?php

namespace App\Views;

use App\Session;
use Illuminate\View\View;


class LayoutComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with("isLoggedIn", Session::get("isLoggedIn"));
    }
}