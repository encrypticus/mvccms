<?php
/**
 * Маршрутизатор системы
 */

namespace Engine\Core\Router;


class Router {
    /**
     * Этот массив будет заполняться вызовом метода $this->add
     * @var array список маршрутов
     */
    private $routes = [];
    /**
     * @var string имя хоста
     */
    private $host;

    /**
     * @var \Engine\Core\Router\UrlDispatcher объект класса UrlDispatcher
     */
    private $dispatcher;

    /**
     * Router constructor.
     * @param $host имя хоста
     */
    public function __construct($host) {
        $this->host = $host;
    }

    /**
     * Добавляет маршрут в список маршрутов (наполняет массив $this->routes)
     * @param $key название маршрута (ключ массива $this->routes)
     * @param $pattern паттерн для маршрута (ключ массива $this->routes['pattern']
     * @param $controller контроллер, который будет обрабатывать данный маршрут (значение ключа массива $this->routes['key']
     * @param string $method GET- или POST- метод
     */
    public function add($key, $pattern, $controller, $method = 'GET') {
        $this->routes[$key] = [
            'pattern' => rtrim($pattern, '/'),
            'controller' => $controller,
            'method' => $method
        ];
    }

    /**
     * Сначала вызывается метод this->getDispatcher, в котором создается объект класса UrlDispatcher с уже
     * проинициализированным в этом методе свойством-массивом этого объекта routes(UrlDispatcher::routes), а затем
     * вызывается метод этого же объекта dispatch(UrlDispatcher::dispatch), в который передаются как аргументы метод запроса
     * к серверу('GET', 'POST') и uri строки запроса. В методе же UrlDispatcher::dispatch создается объект класса
     * DispatchedRoute, в конструктор которого передается имя контроллера
     * Возвращает объект класса DispatchedRoute
     * @param $method метод GET или POST
     * @param $uri REQUEST_URI
     * @return DispatchedRoute
     */
    public function dispatch($method, $uri) {
        return $this->getDispatcher()->dispatch($method, $uri);
    }

    /**
     * Создает объект класса UrlDispatcher и вызывает его метод 'register', который наполняет его свойство $routes, являющееся
     * ассоциативным массивом, значениями, которые хранятся в свойстве-массиве данного объекта(Router); затем метод возвращает
     * этот созданный объект
     * @return UrlDispatcher
     */
    public function getDispatcher() {
        if ($this->dispatcher == null) {
            //создать объект класса UrlDispatcher
            $this->dispatcher = new UrlDispatcher();
            /**
             * Берем массив $this->routes(routes['home'], routes['product'], routes['news'] и проходимся по нему циклом, записывая
             * в переменную $route каждый его элемент, который в свою очередь сам является массивом и имеет вид
             *
             * routes['home']['pattern' => '/'], routes['home']['controller' => 'HomeController:index],
             * routes['product']['pattern' => '/product'], routes['product']['controller' => 'ProductController:index'] и т.д.
             *
             * То-есть содержит те значения, которые мы передали методу Router::add  в файле Cms.php.
             * После этого мы передаем эти значения методу UrlDispatcher::register, который записывает их в его свойство routes
             * UrlDispatcher::routes - это ассоциативный массив с элементами 'GET' => [] 'POST' => [](то есть эти элементы
             * сами являются массивами, но пока еще пустыми. Функция register как раз и заполняет их значениями. После
             * заполнения их значениями массив UrlDispatcher::routes будет иметь вид
             * routes['GET']['/'] = 'HomeController',
             * routes['GET']['/product'] = 'ProductController'
             */
            foreach ($this->routes as $route) {
                $this->dispatcher->register($route['method'], $route['pattern'], $route['controller']);
            }
        }

        return $this->dispatcher;
    }

}