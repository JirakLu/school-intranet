<?php

namespace App;

use App\Session\SessionClass;
use Jenssegers\Blade\Blade;
use Services\Router;

class Kernel {

    public function listen(): void
    {
        $blade = new Blade(__DIR__."/../resources/views", __DIR__."/../cache");

        $router = new Router();
        $action = $router->findRoute();

        session_start();

        //Session defaults
        if (!isset($_SESSION["appInfo"])) {
            $_SESSION["appInfo"] = serialize(new SessionClass());
        }

        //Initializing
        mb_internal_encoding('UTF-8');

        (new $action["controller"]($router, $blade))->{$action["action"]}(array_key_exists("params",$action) ? $action["params"] : null);
    }
}