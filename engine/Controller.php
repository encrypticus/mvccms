<?php

namespace Engine;

use Engine\DI\DI;

/**
 * Базовый класс для всех контроллеров
 * Class Controller
 * @package Engine
 */
abstract class Controller {
    /**
     * @var \Engine\DI\DI DI-контейнер
     */
    protected $di;
    /**
     * объект базы манипуляций с базой данной
     * @var \Engine\Core\Database\Connection объект базы данных
     */
    protected $db;
    /**
     * объект вида
     * @var \Engine\Core\Template\View;
     */
    protected $view;
    /**
     * @var \Engine\Core\Config\Config объект класса Config
     */
    protected $config;
    /**
     * @var \Engine\Core\Request\Request объект класса Request
     */
    protected $request;
    /**
     * @var \Engine\Load объект класса Load
     */
    protected $load;

    /**
     * Controller constructor.
     * @param $di \Engine\DI\DI
     */
    public function __construct(DI $di) {
        $this->di = $di;
        $this->db = $this->di->get('db');
        $this->view = $this->di->get('view');
        $this->config = $this->di->get('config');
        $this->request = $this->di->get('request');
        $this->load = $this->di->get('load');
        //$this->initVars();
    }

    /**
     * Магический метод, предназначен для того, чтобы в контроллерах-наследниках к зависимости DI-контейнера 'model' можно
     * было обращаться как $this->load->model->('[ModelEntity]'), вместо $this->load->$this->di->get('[ModelEntity]')
     * @param $key имя свойства, которое будет перехвачено
     * @return mixed
     */
    public function __get($key) {
        return $this->di->get($key);
    }
    /*public function initVars() {
        $vars = array_keys(get_object_vars($this));
        foreach ($vars as $var) {
            if($this->di->has($var)) {
                $this->{$var} = $this->di->get($var);
            }
        }
        return $this;
    }*/
}