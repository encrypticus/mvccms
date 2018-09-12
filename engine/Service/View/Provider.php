<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 10.08.2018
 * Time: 23:44
 */

namespace Engine\Service\View;

use Engine\Service\AbstractProvider;
use Engine\Core\Template\View;

class Provider extends AbstractProvider{

    /**
     * @var string имя сервиса(зависимости). По сути станет ключом элемента массива DI::container, значением которого станет
     * объект класса View
     */
    public $serviceName = 'view';

    /**
     * Создает объект класса View и помещает его в DI-контейнер
     * @return mixed
     */
    public function init() {
        //создание объекта вида
        $view = new View();
        //добавление зависимости (созданного объекта) в DI-контейнер
        $this->di->set($this->serviceName, $view);
    }
}