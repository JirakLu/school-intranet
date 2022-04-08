<?php

namespace App\Views;

use App\Session;
use Illuminate\View\View;


class LoginComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with("showError", Session::get("showError"));
        $view->with("error", Session::get("error"));
    }
}