<?php

namespace Engine\Core\Database;

/**
 * Вспомогоательный класс, отвечающий за составление sql-запросов
 * Class QueryBuilder
 * @package Engine\Core\Database
 */
class QueryBuilder {
    /**
     * @var array массив, из элементов которого составляется строка запроса
     */
    protected $sql = [];

    /**
     * @var array массив, содержащий свзязываемые значения для метода Connection::bind, передающийся вторым аргументом
     * в метод Connection::query
     */
    public $values = [];

    /**
     * Добавляет в sql['select'] 'SELECT' + значение параметра $fields
     * @param string $fields имя (имена) выбираемого из таблицы поля (полей)
     * @return $this
     */
    public function select($fields = '*') {
        $this->reset();
        $this->sql['select'] = "SELECT {$fields} ";

        return $this;
    }

    /**
     * Добавляет в sql['from'] 'FROM' + значение параметра $table
     * @param $table имя таблицы, из которой производится выборка
     * @return $this
     */
    public function from($table) {
        $this->sql['from'] = "FROM {$table}";

        return $this;
    }

    /**
     * Добавляет в sql['where'] числовой массив со значениями переданных параметров;
     * также добавляет в $this->values[$column] = $value;
     * @param string $column имя поля таблицы, из которого производится выборка
     * @param string $value значение, которое будет вставлено в поле таблицы $column
     * @param string $operator оператор - по умолчанию '='
     * @return $this
     */
    public function where($column, $value, $operator = '=') {
        $this->sql['where'][] = "{$column} {$operator} :{$column}";
        $this->values[$column] = $value;

        return $this;
    }

    /**
     * Добавляет в sql['order_by'] "ORDER BY" + {$field} {$order}
     * @param string $field имя поля таблицы, по которому будет производится сортировка
     * @param string $order метод сортировки - ASC или DESK
     * @return $this
     */
    public function orderBy($field, $order = 'ASC') {
        $this->sql['order_by'] = " ORDER BY {$field} {$order}";

        return $this;
    }

    /**
     * Добавляет в sql['limit'] 'LIMIT' + $number
     * @param integer $number количество выбираемых из таблицы записей
     * @return $this
     */
    public function limit($number) {
        $this->sql['limit'] = " LIMIT {$number}";

        return $this;
    }

    /**
     * Добавляет в sql['update'] 'UPDATE' + $table
     * @param string $table имя таблицы
     * @return $this
     */
    public function update($table) {
        $this->reset();
        $this->sql['update'] = "UPDATE {$table} ";

        return $this;
    }

    /**
     * Добавляет в sql['insert'] 'INSERT INTO TABLE' + $table
     * @param string $table имя таблицы
     * @return $this
     */
    public function insert($table) {
        $this->reset();
        $this->sql['insert'] = "INSERT INTO {$table} ";

        return $this;
    }

    /**
     * Добавляет в sql['SET'] 'SET' + $key + {:$key}
     * @param array $data
     * @return $this
     */
    public function set($data = []) {
        $this->sql['set'] .= "SET ";

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if(count($data) > 1 and next($data)) {
                    $this->sql['set'] .= "{$key} = :{$key}, ";
                } else {
                    $this->sql['set'] .= "{$key} = :{$key}";
                }

                $this->values[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Собирает строку запроса из элеметов массива sql
     *
     * @return string
     */
    public function sql() {
        $sql = '';

        if (!empty($this->sql)) {
            foreach ($this->sql as $key => $value) {
                if ($key == 'where') {
                    $sql .= ' WHERE ';
                    foreach ($value as $where) {
                        $sql .= $where;
                        if (count($value) > 1 and next($value)) {
                            $sql .= ' AND ';
                        }
                    }
                } else {
                    $sql .= $value;
                }
            }
        }

        return $sql;
    }

    /**
     * Очищает массивы sql и values
     * Reset Builder
     */
    public function reset() {
        $this->sql = [];
        $this->values = [];
    }
}