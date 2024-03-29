<?php

namespace App\Controllers;

use App\Views\LayoutComposer;
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

        echo $this->blade->make($view, array_merge($params, $router))->render();
    }


    /**
     * Renders view depending on auth state.
     * @param string $view
     * @param string $redirect
     * @param bool $auth
     * @param array <string, mixed> $params
     * @return void
     */
    protected function renderAuth(string $view, string $redirect, bool $auth, array $params = []): void
    {
        if ($auth) {
            $this->renderView($view, $params);
        } else {
            $this->redirect($redirect);
        }
    }


}