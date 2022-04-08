<?php

namespace App\Views;

use App\Session;
use Illuminate\View\View;


class Layout_PrivateComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with("firstName", Session::get("firstName"));
        $view->with("lastName", Session::get("lastName"));
    }
}