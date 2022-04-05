<?php


use App\Session;

if (!function_exists("mix")) {
    /**
     * @throws Exception
     */
    function mix(string $path): string
    {
        $manifest = json_decode(file_get_contents(dirname(__DIR__) . "/public/mix-manifest.json"), true);
        $domain = $_SERVER['HTTP_HOST'];
        $dirname = explode("\\",dirname(__DIR__));
        $basePath = $dirname[count($dirname)-1] === "www" ? "" : $dirname[count($dirname)-1];
        return "http://$domain/". $basePath  . "/public" . $manifest["/$path"];
    }
}

if (!function_exists("setError")) {

    function setError(string $error): void
    {
        Session::set("showError", true);
        Session::set("error", $error);
    }
}

if (!function_exists("cleanError")) {

    function cleanError(): void
    {
        Session::set("showError", false);
        Session::set("error", "");
    }
}


