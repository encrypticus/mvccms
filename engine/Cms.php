<?php

namespace Engine;

use Cms\Controller\ErrorController;
use Engine\Core\Router\DispatchedRoute;
use Engine\Helper\Common;

class Cms {

    /**
     * @var DI DI-контейнер
     */
    private $di;

    /**
     * @var \Engine\Core\Router\Router объект класса Router
     */
    public $router;

    /**
     * cms constructor.
     * @param $di объект класса DI
     */
    public function __construct(\Engine\DI\DI $di) {
        $this->di = $di;
        $this->router = $this->di->get('router');
    }

    /**
     * Запуск приложения
     */
    public function run() {
        try {
            //подключение файла с роутами
            require_once __DIR__ . '/../' . mb_strtolower(ENV) . '/Route.php';

            /**
             * создаем и инициализируем объект класса UrlDispatcher, а также объект класса DispatchedRoute, посредством метода
             * dispatch класса Router, передав ему в качестве параметров метод запроса к серверу и uri строки запроса,
             * формирование которых осуществляется в методах класса Common::getMethod, Common::getPathUrl
             */
            $routerDispatch = $this->router->dispatch(Common::getMethod(), Common::getPathUrl());

            if ($routerDispatch == null) {
                $routerDispatch = new DispatchedRoute('ErrorController:page404');
            }

            /**
             * Здесь мы берем свойство DispatchedRoute::controller (которое будет проинициализировано в коде выше и иметь вид
             * типа 'HomeController:news'), возвращаемое методом DispatchedRoute::getController, затем полученную строку
             * методом explode разбиваем по разделителю ":" и полученные части строки записываем в массив. Далее мы функцией
             * list записываем значения каждого элемента полученного массива  в переменные $class и $action. В результате мы
             * получаем, например, переменные $class = 'HomeController' и $action = 'news'
             *
             */
            list($class, $action) = explode(':', $routerDispatch->getController(), 2);

            /**
             * в переменную записываем строку с названием класса контроллера вместе с пространством имен
             */
            $controller = '\\' . ENV . '\\Controller\\' . $class;

            /**
             * Создаем контроллер полученного класса и вызываем его метод, прописанный в переменной action, передавая ему
             * необходимые параметры
             */
            call_user_func_array([new $controller($this->di), $action], $routerDispatch->getParams());

        } catch (\Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
    }
}