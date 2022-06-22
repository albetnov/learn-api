<?php

namespace Albet\LearnApi\CRUD\Tools;

class Route
{
    private static $route;

    public static function handleRouting($route)
    {
        self::$route = $route;
        self::home();
        self::detail();
    }

    public static function home()
    {
        header('Access-Control-Allow-Methods: GET');
        preg_match("[CRUD/home]", self::$route, $matches);
        if ($matches && $_SERVER['REQUEST_METHOD'] == 'GET') {
            require_once __DIR__ . '/../fetch.php';
        }
    }

    public static function detail()
    {
        header('Access-Control-Allow-Methods: GET');
        preg_match("[CRUD/get/]", self::$route, $matches);
        if ($matches && $_SERVER['REQUEST_METHOD'] == 'GET') {
            require_once __DIR__ . '/../single.php';
        }
    }
}
