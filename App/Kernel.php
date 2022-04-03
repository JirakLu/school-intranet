<?php

namespace App;

use App\Session\Session;
use Jenssegers\Blade\Blade;
use Services\Router;

class Kernel {

    public function listen(): void
    {
        mb_internal_encoding('UTF-8');

        $blade = new Blade(__DIR__."/../resources/views", __DIR__."/../cache");

        Session::start();

        $router = new Router();
        $action = $router->findRoute();


        (new $action["controller"]($router, $blade))->{$action["action"]}(array_key_exists("params",$action) ? $action["params"] : null);
    }
}