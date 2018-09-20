<?php
/**
 * Вспомогательный класс для класса Router, объект которого использует объект данного класса.
 */

namespace Engine\Core\Router;


class UrlDispatcher {

    /**
     * @var array
     */
    private $methods = [
        'GET',
        'POST'
    ];

    /**
     * @var array список роутов
     */
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * @var array список паттернов
     */
    private $patterns = [
        'int' => '[0-9]+',
        'str' => '[a-zA-Z\.\-_%]+',
        'any' => '[a-zA-Z0-9\.\-_%]+'
    ];

    /**
     * Добавляет паттерны в свойство $this->patterns
     * @param $pattern значение элемента массива
     * @param $key ключ элемента ассоциативного массива
     */
    public function addPattern($key, $pattern) {
        $this->patterns[$key] = $pattern;
    }

    /**
     * Проверяет - существует ли заданный элемент в массиве $this->routes. Если да, то возвращает значение данного
     * элемента, иначе возвращает пустой массив
     * @param $method искомый метод
     * @return array|mixed
     */
    private function routes($method) {
        return isset($this->routes[$method]) ? $this->routes[$method] : [];
    }

    /**
     * Добавляет в массив $this->routes по ключу routes['method']['pattern'] значение controller
     * @param $method метод
     * @param $pattern паттерн
     * @param $controller контроллер
     */
    public function register($method, $pattern, $controller) {
        $convert = $this->convertPattern($pattern);
        $this->routes[strtoupper($method)][$convert] = $controller;
    }

    private function convertPattern($pattern) {

        //если переданный паттерн не содержит символ '(', то просто вернуть данный паттерн как есть
        if (strpos($pattern, '(') == false) {
            return $pattern;
        }
        //иначе преобразовать его и вернуть;
        return preg_replace_callback('#\((\w+):(\w+)\)#', [$this, 'replacePattern'], $pattern);

    }

    /**
     * Функция используется как аргумент второго параметра функции preg_replace_callback.
     * Если, например, паттерн имеет вид /news/(id:int), то алгоритм разбора паттерна будет таков:
     * 1. В фнукции convertPattern этот паттерн будет разбит по регулярному выражению на массив [(id:int), id, int]
     * 2. Этот массив будет передан данной функции
     * 3. Функция вернет строку: ?<{$matches[1]}> - именнованная подмаска (в данном случае ее имя будет id) + результат
     * работы функции strtr, которая возьмет значение matches[2], в данном случае 'int', и заменит его на '[0-9]+'.
     * То-есть функция вернет строку вида 'id[0-9]+'
     * @param $matches Массив параметров. Этот массив будет получен в результате действия функции preg_replace_callback
     * @return string
     *
     */
    private function replacePattern($matches) {
        return "(?<{$matches[1]}>" . strtr($matches[2], $this->patterns) . ')';

    }

    /**
     * Удаляет из переданного массива все ключи с числовыми индексами и возвращает "очищенный" массив
     * @param array $params
     * @return array
     */
    private function processParam($params) {
        foreach ($params as $key => $value) {
            if (is_int($key)) {
                unset($params[$key]);
            }
        }
        return $params;
    }

    /**
     * @param $method
     * @param $uri
     * @return \Engine\Core\Router\UrlDispatcher
     */
    public function dispatch($method, $uri) {

        //удаление концевого слэша
        $uri = rtrim($uri, '/');

        //переменная хранит $this->routes['GET'] или $this->routes['POST']
        $routes = $this->routes(strtoupper($method));

        //если в массиве $routes присутствует ключ со значением $uri, то вернуть объект класса DispatchedRoute
        if (array_key_exists($uri, $routes)) {
            return new DispatchedRoute($routes[$uri]);
        }
        //иначе вернуть результат выполнения функции
        return $this->doDispatch($method, $uri);
    }

    /**
     * В функции выполняется проход по всем элементам массива $this->routes и в них ищется соответсвие uri из строки запроса.
     * То-есть, если, например, найден $route со значением "/news/id[0-9]+" и в строке запроса передан uri со значением
     * "/news/2", то функция preg_match в $uri ищет совпадения по шаблону $pattern (то-есть ищет /news/id[0-9]+ в /news/2).
     * Затем найденное совпадение записывается в массив $params, который в итоге будет иметь вид [0=>'/news/2', 'id'=>2, 1 => 2]
     * Далее этот массив передается функции $this->processParam, которая удаляет из него все элементы с числовыми индексами,
     * в результате чего в массиве остается один элемент с ключом "id" и значением "2" и он возвращается из функции.
     * Этот массив с одним элементом передается конструктору DispatchedRoute вторым аргументом - по сути передается аргумент
     * со значением "2" в данном случае
     * processParam
     *
     * @param string $method метод запроса из строки запроса - будет передан в Cms.php
     * в "$routerDispatch = $this->router->dispatch(Common::getMethod(), Common::getPathUrl())" первым аргументом как
     * Common::getMethod()
     * @param string $uri uri из строки запроса - будет передан в Cms.php
     * в "$routerDispatch = $this->router->dispatch(Common::getMethod(), Common::getPathUrl())" вторым аргументом как
     * Common::getPathUrl()
     * @return DispatchedRoute
     */
    private function doDispatch($method, $uri) {
        foreach ($this->routes[$method] as $route => $controller) {
            $pattern = '#^' . $route . '$#s';
            if (preg_match($pattern, $uri, $params)) {
                return new DispatchedRoute($controller, $this->processParam($params));
            }
        }
    }

}