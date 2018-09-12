<?php
/**
 * Класс-сервис объекта базы данных. В этом классе создается объект класса Connection и помещается в DI-контейнер
 */

namespace Engine\Service\Database;

use Engine\Service\AbstractProvider;
use Engine\Core\Database\Connection;

class Provider extends AbstractProvider {
    /**
     * @var string имя сервиса(зависимости). По сути станет ключом элемента массива DI::container, значением которого станет
     * объект класса Connection
     */
    public $serviceName = 'db';

    /**
     * Создает объект класса Connection и помещает его в DI-контейнер
     * @return mixed
     */
    public function init() {
        //инициализация переменной массивом, содержащимся по указанному пути. Массив содержит значения для инициилизации
        //pdo-конструктора: host, db_name, user, password и charset
        $settings = require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/Config/config.php';
        //создание объекта базы данных
        $db = new Connection($settings);
        //добавление зависимости (созданного объекта) в DI-контейнер
        $this->di->set($this->serviceName, $db);
    }

}