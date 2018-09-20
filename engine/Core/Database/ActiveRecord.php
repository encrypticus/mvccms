<?php

namespace Engine\Core\Database;

use \ReflectionClass;
use \ReflectionProperty;

/**
 * Принадлежит классу Admin\Model\User
 * Trait ActiveRecord
 * @package Engine\Core\Database
 */
trait ActiveRecord {
    /**
     * @var Connection объект базы данных
     */
    protected $db;
    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * ActiveRecord constructor.
     * @param int $id id юзера в базе
     */
    public function __construct($id = 0) {
        global $di;
        $this->db = $di->get('db');
        $this->queryBuilder = new QueryBuilder();
        if ($id) {//если передан параметр - вызвать уканный метод
            $this->setId($id);
        }
    }

    /**
     * @return string имя таблицв в БД
     */
    public function getTable() {
        return $this->table;
    }

    /**
     * Возвращает одну запись из таблицы в виде массива
     * @return array|null
     */
    public function findOne() {
        //строка запроса
        $query = $this->queryBuilder
            ->select()
            ->from($this->getTable())
            ->where('id', $this->id)
            ->sql();
        //массив с результатами запроса
        $result = $this->db->query($query, $this->queryBuilder->values);
        return isset($result[0]) ? $result[0] : null;
    }

    /**
     * Вставляет новую запись в указанную таблицу, если при создании текущего объекта не был передан аргумент $id.
     * Обновляет запись в указанной таблице, id которой соответсвует значению аргумента $id, переданного при создании текущего
     * объекта
     * @return $this
     */
    public function save() {
        //получить массив значений для обновления/вставки свойств в БД
        $properties = $this->getIssetProperties();
        try {//если был передан аргумент $id при создании объекта - обновить запись с соответствующим id в таблице
            if (isset($this->id)) {
                //строка запроса
                $query = $this->queryBuilder
                    ->update($this->getTable())
                    ->set($properties)
                    ->where('id', $this->id)
                    ->sql();
                //отправка запроса
                $this->db->query($query, $this->queryBuilder->values);
            } else {//если же аргумент не был передан - создать новую запись
                //строка запроса
                $query = $this->queryBuilder
                    ->insert($this->getTable())
                    ->set($properties)
                    ->sql();
                //отправка запроса
                $this->db->query($query, $this->queryBuilder->values);
            }
            //вернуть id последнего вставленного элемента
            return $this->db->lastInsertId();
        } catch (\Exception $e) {
            echo $e->getMessage();
        } /*finally {
            return $this;
        }*/
    }

    /**
     * Проходится циклом по массиву, полученному методом getProperties(), каждый элемент которого содержит объект
     * класса ReflectionProperty, и проверяет - содержит ли объект текущего класса свойство (и проинициализировано ли оно),
     * имя которого равно значению свойства 'name' каждого полученного объекта класса ReflectionProperty. Например содержит ли
     * текущий объект свойства 'id' или 'email' и такие же свойства присутствуют в ReflectionProperty->id == 'id',
     * ReflectionProperty->email == 'email'.
     * Возвращает массив существующих и проинициализированных свойств текущего объекта
     * @return array
     */
    private function getIssetProperties() {
        $properties = [];
        foreach ($this->getProperties() as $key => $property) {
            if (isset($this->{$property->getName()})) {
                $properties[$property->getName()] = $this->{$property->getName()};
            }
        }
        return $properties;
    }

    /**
     * На каждое свойство объекта 'User' возвращает массив объектов ReflectionProperty, каждый из которых содержит
     * свойство 'name', содержащее строковое значение, которое равно названию одного глобального метода
     * объекта 'User' - 'id', 'email', 'password', 'role', 'hash', и 'data_reg'
     *
     * @return ReflectionProperty[]
     */
    private function getProperties() {
        //объект класса ReflectionClass на основе объекта текущего класса
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        return $properties;
    }
}