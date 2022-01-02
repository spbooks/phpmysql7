<?php
namespace Ninja;
interface Website {
    public function getDefaultRoute();
    public function getController(string $controllerName);
}