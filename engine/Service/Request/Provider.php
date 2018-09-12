<?php

namespace Engine\Service\Request;


use Engine\Core\Request\Request;
use Engine\Service\AbstractProvider;

/**
 * Класс-сервис, создающий объект класса Request
 * Class Provider
 * @package Engine\Service\Request
 */
class Provider extends AbstractProvider {

    /**
     * @var string имя сервиса(зависимости). По сути станет ключом элемента массива DI::container, значением которого станет
     * объект класса Request
     */
    public $serviceName = 'request';

    /**
     * Создает объект класса Request и помещает его в DI-контейнер
     * @return mixed
     */
    public function init() {
        //создание объекта класса Request
        $request = new Request();
        //добавление зависимости (созданного объекта) в DI-контейнер
        $this->di->set($this->serviceName, $request);
    }
}