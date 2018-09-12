<?php

namespace Engine\Helper;

/**
 * Класс работы с куками
 * Class Cookie
 * @package Engine\Helper
 */
class Cookie {

    /**
     * Устанавливает куки
     * @param string $key ключ массива
     * @param string $value значение массива
     * @param int $time время жизни куков
     */
    public static function set($key, $value, $time = 31536000) {

        setcookie($key, $value, time() + $time, '/');
    }

    /**
     * Возвращает куки по ключу
     * @param string $key ключ массива, по кторому необходимо получить куки
     * @return null
     */
    public static function get($key) {

        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        } else {
            return null;
        }
    }

    /**
     * @param string $key удаляет куку по заданному ключу
     */
    public static function delete($key) {

        if (isset($_COOKIE[$key])) {
            self::set($key, '', -3600);
            unset($_COOKIE[$key]);
        }
    }

}