<?php

namespace Admin\Controller;

use Engine\Controller;
use Engine\DI\DI;
use Engine\Core\Auth\Auth;
use Engine\Core\Database\QueryBuilder;

/**
 * Контроллер, обрабатывющий действия, связанные с авторизацией
 * Class LoginController
 * @package Admin\Controller
 */
class LoginController extends Controller {

    /**
     * @var \Engine\Core\Auth\Auth объект класса Auth
     */
    protected $auth;

    public function __construct(DI $di) {

        parent::__construct($di);

        $this->auth = new Auth();

        if ($this->auth->hashUser() !== null) {//если записаны нужные куки - авторизовать юзера
            //и перенаправить юзера в админку
            header('Location: /admin/');
            exit();
        }
    }

    /**
     * Выводит форму авторизации
     */
    public function form() {
        $this->view->render('login');
    }

    /**
     * Обрабатывает форму авторизации из шаблона login.php
     */
    public function authAdmin() {

        /**
         * Данные из массива POST - POST['email'] и POST['password'] - логин и пароль
         */
        $params = $this->request->post;

        /**
         * Объект класса QueryBuilder
         */
        $queryBuilder = new QueryBuilder();

        /**
         * Строка запроса к базе(получает одну запись по значению логина и пароля из таблицы базы), сформированная объектом
         * класса QueryBuilder
         */
        $select = $queryBuilder
            ->select()
            ->from('user')
            ->where('email', $params['email'])
            ->where('password', md5($params['password']))
            ->limit(1)
            ->sql();

        /**
         * Запрос в базу данных. Переменная $result будет содержать массив данных, полученных из базы. Каждый элемент этого
         * массива тоже является массивом, то есть одной записью таблицы. Фактически этот запрос будет возвращать только
         * одну запись таблицы
         */
        $result = $this->db->query($select, $queryBuilder->values);

        if (!empty($result)) {//если полученный массив не пустой
            //записать в эту переменную первый(и фактически единственный элемент полученного массива - это
            // массив(одна запись таблицы), элементы
            //которого содержат поля полученной записи
            $user = $result[0];

            if ($user->role == 'admin') {//если данный элемент массива равен соответствующему значению, то сформировать
                //хэш и записать в переменную
                $hash = md5($user->id . $user->email . $user->password . $this->auth->salt());

                /**
                 * Строка запроса к базе(обновляет запись в таблице, выбранную по указанному id, вставляя в поле 'hash'
                 * указанное значение), сформированная объектом класса QueryBuilder
                 */
                $update = $queryBuilder
                    ->update('user')
                    ->set(['hash' => $hash])
                    ->where('id', $user->id)
                    ->sql();
                /*echo $update . '<br>';
                print_r($queryBuilder->values);*/

                /**
                 * Выполнить запрос к базе
                 */
                $this->db->query($update, $queryBuilder->values);

                /**
                 * Авторизовать пользователя - записать в куки значение $hash
                 */
                $this->auth->authorize($hash);

                //выполнить перенаправление в админ-панель
                header('Location: /admin/');
            }
        } else {//если полученные из формы логин и пароль не верные - вывести соответствующее сообщение
            echo "Неверные данные для входа";
        }
    }
}