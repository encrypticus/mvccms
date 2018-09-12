<?php

namespace Admin\Model\User;

use Engine\Core\Database\ActiveRecord;

class User {
    use ActiveRecord;// класс использует этот трейт

    /**
     * @var string имя таблицы из базы данных
     */
    protected $table = 'user';

    /**
     * @var int id идентификатор пользователя в базе
     */
    public $id;

    /**
     * @var int email почтовый ящик пользователя в базе
     */
    public $email;

    /**
     * @var string password пароль пользователя в базе
     */
    public $password;

    /**
     * @var string role роль пользователя в базе - user, admin и т.д.
     */
    public $role;

    /**
     * @var string hash хэш пользователя в базе
     */
    public $hash;

    /**
     * @var string date_reg дата регистрации пользователя в базе
     */
    public $date_reg;

    //геттеры и сеттеры для вышеперечисленных свойств

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this;
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param $password
     * @return $this;
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * @param $role
     * @return $this;
     */
    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    /**
     * @return string
     */
    public function getHash() {
        return $this->hash;
    }

    /**
     * @param $hash
     * @return $this;
     */
    public function setHash($hash) {
        $this->hash = $hash;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateReg() {
        return $this->date_reg;
    }

    /**
     * @param string $date_reg
     * @return $this;
     */
    public function setDateReg($date_reg) {
        $this->date_reg = $date_reg;
        return $this;
    }
}