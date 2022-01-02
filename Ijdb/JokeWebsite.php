<?php
namespace Ijdb;
class JokeWebsite implements \Ninja\Website {
    public function getDefaultRoute() {
        return 'joke/home';
    }

    public function getController(string $controllerName):? object {
        $pdo = new \PDO('mysql:host=mysql;dbname=ijdb;charset=utf8mb4', 'ijdbuser', 'mypassword');

        $jokesTable = new \Ninja\DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new \Ninja\DatabaseTable($pdo, 'author', 'id');

        if ($controllerName === 'joke') {
            $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
        }
        else if ($controllerName === 'register') {
            $controller = new \Ijdb\Controllers\Register($authorsTable);
        }
        else {
            $controller = null;
        }

        return $controller;
    }
}