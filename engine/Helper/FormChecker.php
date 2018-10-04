<?php

namespace Engine\Helper;

/**
 * Класс проверки формы
 *
 * Class FormChecker
 * @package Engine\Helper
 */
class FormChecker {

    /**
     * @var array массив ошибок
     */
    public static $errors = [];

    /**
     * Проверяет на пустоту элемент формы
     *
     * @param string $item элемент POST-массива
     * @return bool
     */
    public static function isEmpty($item) {

        if (empty(trim($item))) {
            return true;
        }
        return false;
    }

    /**
     * Добавляет в массив $errors новый элемент с ключом $key и значением $value
     *
     * @param string $key ключ массива
     * @param string $value значение ключа
     */
    public static function setError($value) {
        self::$errors[] = $value;
    }

    /**
     * Проверяет был ли файл загружен на сервер
     *
     * Проверяет - равен ли переданный аргумент нулю, и если равен, то возвращает true, иначе false. Аргументом передается
     * FILES['inputname']['size'] - размер загруженного файла. Если файл не
     * был загружен - значение аргумента будет равно 0 и метод вернет true, иначе false
     *
     * @param int $bookFileSize FILES['inputname']['size']
     * @return bool
     */
    public static function bookFileNotUpload($bookFileSize) {

        if ($bookFileSize == 0) return true;
        return false;
    }

    /**
     * Проверяет - был ли передан файл обложки книги из формы
     *
     * @param int $fileSize FILES['inputname']['size'] значение размера файла из массива FILES
     * @return bool
     */
    public static function fileUpload($fileSize) {
        if ($fileSize !== 0) return true;
        return false;
    }

    /**
     * Проверяет на присутствие ошибок
     *
     * Проверяет на пустоту массив $errors - если массив не пустой, возвращает true, иначе false
     * @return bool
     */
    public static function errorsFound() {
        return !empty(self::$errors);
    }

    /**
     * Выводит все ошибки
     *
     * Проходится циклом по всем элементам массива $errors и отображает каждый его элемент, оборачивая его в абзац
     */
    public static function displayErrors() {

        /**@var string $error сообщение об ошибке */
        foreach (self::$errors as $error) {
            echo "<p>" . $error . "</p>";
        }
    }

    public static function checkFields(array $params, array $errors) {

        foreach ($params as $param => $value) {
            if (self::isEmpty($value)) self::setError($errors[$param]);
        }
    }

    public static function issetErrors() {
        if(self::errorsFound()) {
            self::displayErrors();
            return true;
        }
    }

}