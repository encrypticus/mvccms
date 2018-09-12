<?php

namespace Cms\Controller;

/**
 * Класс контроллера, который будет срабатывать при попытке перехода по несуществующему адресу
 * Class ErrorController
 * @package Cms\Controller
 */
class ErrorController extends CmsController {

    public function page404() {
        echo "404 Page";
    }

}