<?php

namespace App\Router;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class RouterFactory
{
    /**
     * @return \Nette\Application\IRouter
     */
    public function createRouter()
    {
        $router = new RouteList;
        $router[] = new Route('administration[/<presenter>[/<action>[/<id>]]]', [
            'module' => 'Admin',
            'presenter' => 'Main',
            'action' => 'default',
            'id' => NULL
        ]);

        $router[] = new Route('<presenter>/<action>[/<id>]', [
            'module' => 'Front',
            'presenter' => 'Homepage',
            'action' => 'default',
            'id' => NULL
        ]);
        return $router;
    }
}
