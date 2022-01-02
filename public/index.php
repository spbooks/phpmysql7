<?php
include __DIR__ . '/../includes/autoload.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');

$jokeWebsite = new \Ijdb\JokeWebsite;
$entryPoint = new \Ninja\EntryPoint($jokeWebsite);
$entryPoint->run($uri);