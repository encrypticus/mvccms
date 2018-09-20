<?php

namespace Engine\Core\Router;


class DispatchedRoute {

    /**
     * @var \Cms\Controller\CmsController
     */
    private $controller;

    /**
     * @var
     */
    private $params;

    public function __construct($controller, $params = []) {
        $this->controller = $controller;
        $this->params = $params;
    }

    /**
     * Возвращает контроллер
     * @return mixed
     */
    public function getController() {
        return $this->controller;
    }

    /**
     * Возвращает параметры
     * @return mixed
     */
    public function getParams() {
        return $this->params;
    }
}