<?php

namespace Admin\Model\User;

use Engine\Model;

/**
 * Класс-наследник класса Model. Содержит методы работы с сущностью 'User'
 * Class UserRepository
 * @package Admin\Model\User
 */
class UserRepository extends Model {

    /**
     * Возвращает массив, каждый элемент которого содержит запись пользователя из БД
     * @return array|int|null
     */
    public function getUsers() {
        $getAllUsers = $this->queryBuilder
            ->select()
            ->from('user')
            ->sql();
        $users = $this->db->query($getAllUsers);
        return $users;
    }

    public function test() {
        /*$user = new User(1);
        $user->setEmail('encrypticus@gmail.com');
        $user->setPassword('spaik87055091802');
        $user->setRole('user');
        $user->setHash('new_user');
        $user->save();*/
    }

}