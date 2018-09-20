<?php

namespace Engine\Service\Router;

use Engine\Service\AbstractProvider;
use Engine\Core\Router\Router;


class Provider extends AbstractProvider{
    /**
     * @var string имя сервиса(зависимости). По сути станет ключом элемента массива DI::container, значением которого станет
     * объект класса Router
     */
    public $serviceName = 'router';

    /**
     * Создает объект класса Router и помещает его в DI-контейнер
     * @return mixed
     */
    public function init() {
        //создание объекта роутера
        $router = new Router('https://mvccms.ru/');
        //добавление зависимости (созданного объекта) в DI-контейнер
        $this->di->set($this->serviceName, $router);
    }

}