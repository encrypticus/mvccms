<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 15.08.2018
 * Time: 19:40
 */

namespace Engine\Core\Request;

/**
 * Класс-обертка для работы с суперглобальными массивами сервера
 * Class Request
 * @package Engine\Core\Request
 */
class Request {
    /**
     * @var array ссылка на суперглобальный массив GET
     */
    public $get = [];

    /**
     * @var array ссылка на суперглобальный массив POST
     */
    public $post = [];

    /**
     * @var array ссылка на суперглобальный массив REQUEST
     */
    public $request = [];

    /**
     * @var array ссылка на суперглобальный массив COOKIE
     */
    public $cookie = [];

    /**
     * @var array ссылка на суперглобальный массив FILES
     */
    public $files = [];

    /**
     * @var array ссылка на суперглобальный массив SERVER
     */
    public $server = [];

    /**
     * Request constructor.
     */
    function __construct() {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->request = $_REQUEST;
        $this->cookie = $_COOKIE;
        $this->files = $_FILES;
        $this->server = $_SERVER;
    }

}