<?php
/**
 * Этот класс используется при вызове метода Router::dispatch для передачи этому методу двух аргументов, которые передаются
 * как возвращаемые значения двух методов этого класса - getMethod и getPathUrl
 */

namespace Engine\Helper;


class Common {

    /**
     * Проверяет был ли запрос к этой странице отправлен методом POST, и если это так, то метод возвращает true, иначе false
     * @return bool
     */
    public function isPost() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            return true;
        }

        return false;
    }

    /**
     * аналогичен предыдущему методу, за исключением проверки на GET-метод
     * @return bool
     */
    public function isGet() {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            return true;
        }

        return false;
    }

    /**
     * Возвращает метод(GET или POST), использованный для запроса к серверу
     * @return mixed
     */
    public static function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Возвращает REQUEST_URI - uri страницы - часть адреса после доменного имени
     * @return bool|string
     */
    public static function getPathUrl() {
        $pathUrl = $_SERVER['REQUEST_URI'];
        //если в запросе при передаче параметров был использован знак вопроса, то найти его позицию и записать в переменную
        if($position = strpos($pathUrl, '?')) {
            //вырезать из uri найденный знак вопроса
            $pathUrl = substr($pathUrl, 0, $position);
        }
        //вернуть uri, но уже без знака вопроса, если таковой был найден
        return $pathUrl;
    }
}