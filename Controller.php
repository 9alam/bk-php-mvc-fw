<?php
/**
 * User: ifelsetalents
 * Date: 03/11/2020
 * Time: 10:01 AM
 */

namespace bk\phpmvcfw;

use bk\phpmvcfw\Application;
use bk\phpmvcfw\middlewares\BaseMiddleware;

/**
 * Class Controller
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package bk\phpmvcfw
 */


class Controller 
{
    public string $layout = 'main';

    public string $action = '';

    /**
     * @var \bk\phpmvcfw\middleware\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function render($view, $params = []) {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }
    

    /**
     * Get the value of middlewares
     *
     * @return  \bk\phpmvcfw\middleware\BaseMiddleware[]
     */ 
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}