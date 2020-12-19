<?php
/**
 * User: ifelsetalents
 * Date: 03/11/2020
 * Time: 10:01 AM
 */

namespace bk\phpmvcfw;
use bk\phpmvcfw\Application;
use bk\phpmvcfw\Request;
use bk\phpmvcfw\Response;
use app\controllers\AuthController;
use bk\phpmvcfw\exception\NotFoundException;
use bk\phpmvcfw\form\Form;

/**
 * Class Router
 *
 * @author  Bachir Kadiri <bkadiri@gmail.com>
 * @package bk\phpmvcfw
 */


class Router
{
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $url, $callback)
    {   
        $this->routes['get'][$url] = $callback;
    }

    public function post(string $url, $callback)
    {
        $this->routes['post'][$url] = $callback;
    }

    public function resolve()
    {
       // echo '<pre>'; var_dump($_SERVER); echo '</pre>';
        $path = $this->request->getUrl();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if($callback === false) {
            //Application::$app->response->setStatusCode(404);
            //$this->response->setStatusCode(404);
            //return $this->renderContent("not found");
            //return $this->renderView('_404');
            throw new NotFoundException();
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
       
        if (is_array($callback)) {
            //$callback[0] = new $callback[0]();
            //instance of controller created replaced by this
            /** @var \bk\phpmvcfw\Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = Application::$app->controller;

            foreach($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }
       
        //echo '<pre>'; var_dump($callback); echo '</pre>';
        return call_user_func($callback, $this->request, $this->response);

    }

    // public function renderView($view, $params = [])
    // {
    //     return Application::$app->view->renderView($view, $params);
    // }

    // public function renderContent($viewContent)
    // {
    //     $layoutContent = $this->layoutContent();
    //     return str_replace('{{content}}', $viewContent, $layoutContent);
    // }

    // protected function layoutContent() {
    //     //$layout = Application::$app->controller->layout;
    //     $layout = Application::$app->layout;
    //     if (Application::$app->controller) {
    //         $layout = Application::$app->controller->layout;
    //     }
    //     ob_start();
    //     include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
    //     return ob_get_clean();
    // }

    // protected function renderOnlyView($view, $params) {
    //     foreach ($params as $key => $value) {
    //         $$key = $value;
    //     }
    //     ob_start();
    //     include_once Application::$ROOT_DIR."/views/$view.php";
    //     return ob_get_clean();
    // }
    
}