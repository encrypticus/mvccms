<?php

namespace Engine\Core\Config;

/**
 * Класс хранит хранит в себе методы получения загрузки файлов с конфигами и получения из них массивов-конфигов
 * Class Config
 * @package Engine\Core\Config
 */
class Config {

    /**
     * Функция возвращает массив-конфиг
     * @param $key
     * @param string $group
     * @return null|array
     */
    public static function item($key, $group = 'main') {
        $groupItems = static::file($group);

        return isset($groupItems[$key]) ? $groupItems[$key] : null;
    }

    /**
     * Функция возвращает двумерный массив с массивами-конфигами
     * @param string $group строка с именем группы. Значение этой строки - database, main и т.д - это имя файла по пути
     * admin/Config или cms/Config - database.php или main.php - в зависимости от окружения - Admin или Cms
     * @return bool|array
     * @throws \Exception
     */
    public static function file($group) {
        //путь к файлу конфига
        $path = $_SERVER['DOCUMENT_ROOT'] . '/' . mb_strtolower(ENV) . '/Config/' . $group . '.php';

        if (file_exists($path)) {//если файл существует
            //подключить его - в переменной должен оказаться массив
            $items = require_once $path;
            //если переменная содержит массив - вернуть его
            if (!empty($items)) {
                return $items;
            } else {//иначе вывести сообщение об ошибке
                throw new \Exception(
                    sprintf('Config file <strong>%s</strong> is not a valid array', $path)
                );
            }

        } else {//если файл по указанному пути не существует - вывести сообщение об ошибке
            throw new \Exception(
                sprintf('Cannot load config from file, file <strong>%s</strong> does not exists.', $path)
            );
        }

        return false;
    }

}