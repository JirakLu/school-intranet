<?php

namespace App\Views;

use App\Session;
use Illuminate\View\View;


class LoginComposer
{

    public function __construct() {

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with("isLoggedIn", Session::get("isLoggedIn"));
        $view->with("showError", Session::get("showError"));
        $view->with("error", Session::get("error"));
    }
}