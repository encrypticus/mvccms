<?php

namespace Engine;

use Engine\Core\Database\QueryBuilder;
use Engine\DI\DI;

/**
 * Class Model
 * @package Engine Базовый класс для всех моделей приложения
 */
abstract class Model {

    /**
     * @var \Engine\DI\DI объект di-контейнера
     */
    protected $di;

    /**
     * @var \Engine\Core\Database\Connection объект работы с базой данных
     */
    protected $db;

    /**
     * @var \Engine\Core\Config\Config объект класса Config
     */
    protected $config;

    /**
     * @var \Engine\Core\Database\QueryBuilder;
     */
    public $queryBuilder;

    function __construct(DI $di) {
        $this->di = $di;
        $this->db = $this->di->get('db');
        $this->config = $this->di->get('config');
        $this->queryBuilder = new QueryBuilder();
    }
}