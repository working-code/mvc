<?php

namespace App\Core;

use App\Controllers\Blog;
use App\Controllers\User;
use PDO;
use Exception;

class Application
{
    /** @var Route */
    private $route;
    /** @var MainController */
    private $controller;
    private $nameMethod;

    public function __construct()
    {
        $this->route = new Route();
    }

    private function includeFiles()
    {
        $pathConfig = '..' . DIRECTORY_SEPARATOR . 'config.php';
        if (!file_exists($pathConfig)) {
            throw new ConfigException('config.php not found');
        }
        require_once $pathConfig;
    }

    private function initDb()
    {
        MainModel::setDb(new PDO(DSN, DB_USERNAME, DB_PASSWORD));
    }

    private function addRoutes()
    {
        $this->route->addRoute('/', User::class, 'login');
        $this->route->addRoute('/user/blog', Blog::class, 'index');
        $this->route->addRoute('/blog/api', Blog::class, 'getMessage');
    }

    private function initController()
    {
        $nameController = $this->route->getControllerName();
        if (!class_exists($nameController)) {
            throw new ControllerException("class not exists {$nameController}");
        }
        $this->controller = new $nameController();
    }

    private function initMethod()
    {
        $nameMethod = $this->route->getMethodName();
        $nameController = $this->route->getControllerName();
        if (!method_exists($this->controller, $nameMethod)) {
            throw new ControllerException("method not exists in class {$nameController}");
        }
        $this->nameMethod = $nameMethod;
    }

    private function initView()
    {
        $view = new MainView();
        $this->controller->setView($view);
    }

    public function run()
    {
        try {
            session_start();
            $this->includeFiles();
            $this->addRoutes();
            $this->initController();
            $this->initMethod();
            $this->initView();
            $this->initDb();

            echo $this->controller->{$this->nameMethod}();
        } catch (RedirectException $e) {
            header("Location: " . $e->getUrl());
            die();
        } catch (ControllerException $e) {
            header("HTTP/1.0 404 Not Found");
            echo "Упс, что-то пошло не так";
        } catch (ConfigException $e) {
            echo "Переименуюте файл config-example.php в config.php<br/>{$e->getMessage()}";
        }
    }
}
