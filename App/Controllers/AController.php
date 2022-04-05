<?php

namespace App\Controllers;

use App\Views\NavbarComposer;
use Error;
use Illuminate\View\View;
use Jenssegers\Blade\Blade;
use Services\Router;

abstract class AController
{

    /** @var Router */
    private Router $router;

    /** @var Blade */
    private Blade $blade;

    public function __construct(Router $router, Blade $blade)
    {
        $this->router = $router;
        $this->blade = $blade;
    }

    /**
     * Redirects to a different url.
     * @param string $endpoint
     * @param int|null $statusCode
     * @return void
     */
    protected function redirect(string $endpoint, ?int $statusCode = 303): void
    {
        $endpoint = $endpoint[0] === "/" ? substr($endpoint, 1) : $endpoint;
        $this->router->redirect($endpoint, $statusCode);
    }

    /**
     * Forwards to a different controller without refresh.
     * @param string $controller
     * @param string $action
     * @param string|null $params
     * @return void
     */
    protected function forward(string $controller, string $action, ?string $params = ""): void
    {
        $this->router->forward($controller, $action, $this->router, $this->blade, $params);
    }

    /**
     * Throws new error.
     * @param string $msg
     * @return void
     */
    protected function error(string $msg): void
    {
        throw new Error($msg);
    }

    /**
     * Returns json as response.
     * @param array<string, mixed> $jsonData
     * @return void
     */
    protected function returnJson(array $jsonData): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($jsonData);
    }

    private function addComposer(string $viewsDir): void
    {
        $composers = [];

        foreach (glob(__DIR__ . "/../Views/*") as $class) {
            $className = explode("/", $class);
            $className = array_pop($className);
            $className = explode(".", $className);
            $className = array_shift($className);
            $composers[$class] = strtolower($className);
        }

        foreach (glob($viewsDir."/*") as $file) {
            if (is_dir($file)) {
                $this->addComposer($file);
            } else {
                $fileName = explode("/", "$file");
                $fileName = array_pop($fileName);
                $fileName = explode(".", $fileName);
                $fileName = array_shift($fileName);
                $fileName = strtolower($fileName . "composer");


                if (in_array($fileName, $composers)) {
                    $classPath = array_search($fileName, $composers);

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

    /**
     * Renders view using blade template engine.
     * @param string $view
     * @param array<string, mixed> $params
     */
    protected function renderView(string $view, array $params = []): void
    {
        $router = ["generateBase" => fn() => $this->router->generateBase(),
            "getActiveUrl" => fn() => $this->router->getActiveURL(),
            "createLink" => fn($link) => $this->router->createLink($link)];


        $this->addComposer(__DIR__."/../../resources/views");

        echo $this->blade->make($view, array_merge($params, $router))->render();
    }


}