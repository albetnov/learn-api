<?php

namespace Albet\LearnApi\CRUD\Tools;

use Albet\LearnApi\CRUD\Init;

/**
 * This file will handle the routing for CRUD. 
 * Since single route like "/item" may be able to be used for GET and POST.
 * This file will call the corresponding php file based on request method.
 */
class Route
{
    private static $route;

    public static function handleRouting($route)
    {
        Init::initialize(); // Initialize DB Checking every request.
        self::$route = $route;
        self::home();
        self::detail();
        self::search();
        self::paginate();
        self::create();
        self::update();
        self::delete();
        self::upload();
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

    public static function search()
    {
        header('Access-Control-Allow-Methods: GET');
        preg_match("[CRUD/search/]", self::$route, $matches);
        if ($matches && $_SERVER['REQUEST_METHOD'] == 'GET') {
            require_once __DIR__ . '/../search.php';
        }
    }

    public static function paginate()
    {
        header('Access-Control-Allow-Methods: GET');
        preg_match("[CRUD/paginate]", self::$route, $matches);
        if ($matches && $_SERVER['REQUEST_METHOD'] == 'GET') {
            require_once __DIR__ . '/../pagination.php';
        }
    }

    public static function create()
    {
        header('Access-Control-Allow-Methods: POST');
        preg_match('[CRUD/create]', self::$route, $matches);
        if ($matches && $_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once __DIR__ . '/../create.php';
        }
    }

    public static function update()
    {
        header('Access-Control-Allow-Methods: PUT');
        preg_match('[CRUD/update/]', self::$route, $matches);
        if ($matches && $_SERVER['REQUEST_METHOD'] == 'PUT') {
            require_once __DIR__ . '/../update.php';
        }
    }

    public static function delete()
    {
        header('Access-Control-Allow-Methods: DELETE');
        preg_match('[CRUD/delete/]', self::$route, $matches);
        if ($matches && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            require_once __DIR__ . '/../delete.php';
        }
    }

    public static function upload()
    {
        header('Access-Control-Allow-Methods: GET, POST');
        preg_match('[CRUD/upload]', self::$route, $matches);
        if ($matches) {
            require_once __DIR__ . '/../upload.php';
        }
    }
}
