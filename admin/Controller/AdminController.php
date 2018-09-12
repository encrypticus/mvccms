<?php

namespace Admin\Controller;

use Engine\Controller;
use Engine\Core\Auth\Auth;

/**
 * Базовый контроллер, от которого будут наследоваться все контроллеры
 * Class AdminController
 * @package Cms\Controller
 */
class AdminController extends Controller {

    /**
     * @var Auth \Engine\Core\Auth объект класса Auth
     */
    protected $auth;
    /**
     * AdminController constructor.
     * @param $di \Engine\DI\DI
     */
    public function __construct($di) {

        parent::__construct($di);

        $this->auth = new Auth();

        if ($this->auth->hashUser() == null) {
            header('Location: /admin/login/');
            exit;
        }

        //$this->checkAuthorization();

        if (isset($this->request->get['logout'])) {
            $this->auth->unAuthorize();
        }
    }

    /**
     * Проверяет - зарегистрирован ли пользователь
     */
    private function checkAuthorization() {

    }

    public function logout() {
        $this->auth->unAuthorize();
        header('Location: /admin/login/');
        exit;
    }
}