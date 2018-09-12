<?php

namespace Admin\Controller;

/**
 * Класс контроллера, который будет срабатывать при попытке перехода по несуществующему адресу
 * Class ErrorController
 * @package Admin\Controller
 */
class ErrorController extends AdminController {

    public function page404() {
        echo "404 Page";
    }

}