<?php

namespace Engine\Core\Auth;

use Engine\Helper\Cookie;

/**
 * Класс системы авторизации
 * Class Auth
 * @package Engine\Core\Auth
 */
class Auth implements AuthInterface {

    /**
     * @var bool булево значение, означающее - авторизован ли пользователь
     */
    protected $authorized = false;

    /**
     * @var string пользователь
     */
    protected $hash_user;

    /**Возвращает булево значение в зависимости авторизован ли пользователь или нет
     * @return bool
     */
    public function authorized() {
        return $this->authorized;
    }

    /** Возвращает пользователя
     * @return string
     */
    public function hashUser() {
        return Cookie::get('auth_user');
    }

    /**
     * Авторизует нового пользователя
     * @param string $user
     */
    public function authorize($user) {
        Cookie::set('auth_authorized', true);
        Cookie::set('auth_user', $user);
/*
        $this->authorized = true;
        $this->hash_user = $user;*/
    }

    /**
     * Удаляет авторизованного пользователя
     */
    public function unAuthorize() {
        Cookie::delete('auth_authorized');
        Cookie::delete('auth_user');
/*
        $this->authorized = false;
        $this->hash_user = null;*/
    }

    /**
     * Добавляет случайное строковое значение к паролю пользователя
     * @return string
     */
    public static function salt() {
        return (string) rand(10000000, 99999999);
    }

    /**
     * Создает хэш пароля
     * @param string $password
     * @param string $salt
     * @return string
     */
    public static function encryptPassword($password, $salt = '') {
        return hash('sha256', $password . $salt);
    }
}