<?php

namespace App\Views;

use Illuminate\View\View;


class NavbarComposer
{


    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with("test", "askdhaskjhdasda");
    }
}