<?php
/**
 * Класс работы с базой данных. Класс создает объект класса PDO, выполняет запросы к базе и возвращает результаты
 * из базы
 */

namespace Engine\Core\Database;

use Engine\Core\Config\Config;


class Connection {
    /**
     * @var \PDO pdo объект
     */
    private $pdo;
    /**
     * @var bool есть ли подключение к базе данных
     */
    private $isConnected;
    /**
     * @var \PDOStatement PDO statement объект
     */
    private $statement;
    /**
     * @var array массив значений для инициилизации pdo-конструктора: host, db_name, user, password и charset
     */
    protected $settings = [];
    /**
     * @var array массив параметров для метода $this->query
     */
    private $parameters = [];

    public function __construct(array $settings) {
        $this->settings = Config::file('database');
        $this->connect();
    }

    /**
     * Подключение к базе данных
     */
    private function connect() {
        //имя хоста и базы данных - первый параметр для pdo-конструктора
        $dsn = "mysql:host={$this->settings['host']};dbname={$this->settings['dbname']};";
        //логин пользователя базы данных - второй параметр для pdo-конструктора
        $user = $this->settings['user'];
        //пароль  пользователя базы данных - третий параметр для pdo-конструктора
        $password = $this->settings['password'];
        $charset = $this->settings['charset'];

        try {
            //создать объект pdo
            $this->pdo = new \PDO($dsn, $user, $password, [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->settings['charset']]);
            //установить режим обработки ошибок pdo
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            //выключить режим эмуляции подготовленных запросов pdo
            //$this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            //подключение установлено
            $this->isConnected = true;

        } catch (\PDOException $exception) {
            exit($exception->getMessage());
        }
    }

    /**
     * закрывает соединение с базой данных
     */
    public function closeConnection() {
        $this->pdo = null;
    }

    /**
     * инициализация запроса
     * @param $query строка запроса
     * @param array $parameters массив с параметрами запроса
     */
    private function init($query, array $parameters = []) {
        //если соединение не установлено
        if (!$this->isConnected) {
            //установить соединение
            $this->connect();
        }
        try {
            //подготовить запрос
            $this->statement = $this->pdo->prepare($query);
            //привязать параметры к запросу
            $this->bind($parameters);
            //если массив $parameters не пустой, то-есть в метод this->query был передан второй параметр - массив
            if (!empty($this->parameters)) {
                /**
                 * для каждого элемента массива проверить тип данных привязываемого значения и в зависимости от результата
                 * присвоить переменной $type одну из констант PDO
                 */
                foreach ($this->parameters as $param => $value) {
                    if (is_int($value[1])) {
                        $type = \PDO::PARAM_INT;
                    } elseif (is_bool($value[1])) {
                        $type = \PDO::PARAM_BOOL;
                    } elseif (is_null($value[1])) {
                        $type = \PDO::PARAM_NULL;
                    } else {
                        $type = \PDO::PARAM_STR;
                    }
                    //связать параметр с заданным значением
                    $this->statement->bindValue($value[0], $value[1], $type);
                }
            }
            //выполнить запрос
            $this->statement->execute();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
        //очистить массив параметров запроса
        $this->parameters = [];
    }

    /**
     * инициализирует массив $this->parameters, который будет использоваться в методе bindValue при связывании
     * параметров с заданными значениями
     * @return void
     * @param array $parameters
     */
    private function bind(array $parameters) {
        //если переданный аргумент не пустой и является массивом
        if (!empty($parameters) and is_array($parameters)) {
            //создать массив с числовыми ключами, в качестве значений которых выступают ключи массива $parameters
            $columns = array_keys($parameters);
            //проинициализировать массив $this->parameters
            foreach ($columns as $i => &$column) {
                $this->parameters[] = [
                    ':' . $column,
                    $parameters[$column]
                ];
            }
        }
    }

    /**
     * выполняет запрос к базе данных
     * @param string $query строка запроса
     * @param array $parameters массив привязываемых пареметров
     * @param int $mode режим вывода
     * @return array|int|null возвращаемое значение
     */
    public function query(string $query, array $parameters = [], $mode = \PDO::FETCH_OBJ) {
        //обрезать пробелы в строке запроса
        $query = trim(str_replace('\r', '', $query));
        //инициализировать запрос
        $this->init($query, $parameters);
        /**
         * сначала заменить все переводы строк в строке запроса на пробелы, затем разбить строку запроса на массив
         * по разделителю-пробелу
         */
        $rawStatement = explode(' ', preg_replace("/\s+|\t+|\n+/", " ", $query));
        /**
         * взять первый элемент из массива $rawStatement, который может быть равен одному из следующих строковых значений:
         * select, show, insert, update, delete, затем привести его к нижнему регистру
         */
        $statement = strtolower($rawStatement[0]);
        //если значение переменной $statement равно select или show - вернуть массив результатов из базы данных
        if ($statement === 'select' || $statement === 'show') {
            return $this->statement->fetchAll($mode);
            //если же значение переменной $statement равно insert, update или delete - вернуть числовое значение - количество затротутых запросом записей в базе данных
        } elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
            return $this->statement->rowCount();
        } else {
            //иначе вернуть нулевое значение
            return null;
        }
    }

    /**
     * @return string
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

}


