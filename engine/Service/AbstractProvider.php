<?php
/**
 * Родительский класс для всех классов-сервисов
 */

namespace Engine\Service;


abstract class AbstractProvider {
    /**
     * @var \Engine\DI\DI объект dependency injection контейнера
     */
    protected $di;

    /**
     * AbstractProvider constructor.
     * @param \Engine\DI\DI $di
     */
    public function __construct(\Engine\DI\DI $di) {
        $this->di = $di;
    }

    /**
     * В этом методе создется объект класса ядра системы - роутер, объект базы данных и другие - и помещается в DI-контейнер
     * @return mixed
     */
    abstract function init();

}