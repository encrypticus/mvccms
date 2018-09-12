<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 01.08.2018
 * Time: 20:58
 */

namespace Engine\Service\Config;

use Engine\Service\AbstractProvider;
use Engine\Core\Config\Config;


class Provider extends AbstractProvider{
    /**
     * @var string имя сервиса(зависимости). По сути станет ключом элемента массива DI::container, значением которого станет
     * массив $config
     */
    public $serviceName = 'config';

    /**
     * Создает объект класса Router и помещает его в DI-контейнер
     * @return mixed
     */
    public function init() {
        //добавление конфигов
        $config['main'] = Config::file('main');
        $config['database'] = Config::file('database');
        //добавление зависимости (созданного массива конфигов) в DI-контейнер
        $this->di->set($this->serviceName, $config);
    }

}