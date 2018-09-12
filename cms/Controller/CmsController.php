<?php

namespace Cms\Controller;

use Engine\Controller;

/**
 * Базовый контроллер, от которого будут наследоваться все контроллеры
 * Class CmsController
 * @package Cms\Controller
 */
class CmsController extends Controller {

    /**
     * CmsController constructor.
     * @param $di \Engine\DI\DI
     */
    public function __construct($di) {
        parent::__construct($di);
    }
}