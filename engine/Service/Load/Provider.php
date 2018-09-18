<?php

namespace Engine\Service\Load;


use Engine\Load;
use Engine\Service\AbstractProvider;

/**
 * Класс-сервис, создающий объект класса Load
 * Class Provider
 * @package Engine\Service\Load
 */
class Provider extends AbstractProvider {

    /**
     * @var string имя сервиса(зависимости). По сути станет ключом элемента массива DI::container, значением которого станет
     * объект класса Load
     */
    public $serviceName = 'load';

    /**
     * Создает объект класса Load и помещает его в DI-контейнер
     * @return mixed
     */
    public function init() {
        //создание объекта класса Load
        $load = new Load($this->di);
        //добавление зависимости (созданного объекта) в DI-контейнер
        $this->di->set($this->serviceName, $load);
    }
}