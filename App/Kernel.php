<?php

namespace App;

use Jenssegers\Blade\Blade;
use Services\AuthService;
use Services\Router;

class Kernel {

    /** @var array<String> */
    private array $viewComposers = [];
    private Blade $blade;

    public function __construct()
    {
        foreach (glob(__DIR__ . "/Views/*") as $class) {
            $className = explode("/", $class);
            $className = array_pop($className);
            $className = explode(".", $className);
            $className = array_shift($className);
            $this->viewComposers[$class] = strtolower($className);
        }
    }

    private function registerComposers(string $viewsDir): void
    {
        foreach (glob($viewsDir."/*") as $file) {
            if (is_dir($file)) {
                $this->registerComposers($file);
            } else {
                $fileName = explode("/", "$file");
                $fileName = array_pop($fileName);
                $fileName = explode(".", $fileName);
                $fileName = array_shift($fileName);
                $fileName = strtolower($fileName . "composer");


                if (in_array($fileName, $this->viewComposers)) {
                    $classPath = array_search($fileName, $this->viewComposers);

                    $file = explode("views/", $file);
                    $file = array_pop($file);
                    $file = str_replace("/", ".", $file);
                    $file = str_replace(".blade.php", "", $file);

                    $classPath = explode("Views/", $classPath);
                    $classPath = array_pop($classPath);
                    $classPath = str_replace(".php", "", $classPath);

                    $this->blade->composer($file, "App\Views\\$classPath");

                }
            }
        }
    }

    public function listen(): void
    {
        mb_internal_encoding('UTF-8');

        $this->blade = new Blade(__DIR__."/../resources/views", __DIR__."/../cache");

        $this->registerComposers(__DIR__ . "/../resources/views");

        Session::start();

        if (!Session::get("isLoggedIn") && isset($_COOKIE["remember"])) {
            $authService = new AuthService();
            $authService->checkAuthCookie($_COOKIE["remember"]);
        }

        $router = new Router();
        $action = $router->findRoute();


        (new $action["controller"]($router, $this->blade))->{$action["action"]}(array_key_exists("params",$action) ? $action["params"] : null);
    }
}