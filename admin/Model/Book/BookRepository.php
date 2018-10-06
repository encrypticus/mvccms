<?php

namespace Admin\Model\Book;

use Engine\Core\FileLoader\FileLoader;
use Engine\Model;

/**
 * Содержит методы работы с БД, работает с моделью сущности Book
 *
 * Class BookRepository
 * @package Admin\Model\Book
 */
class BookRepository extends Model {

    /**
     * Получает данные всех книг из БД и возвращает их как массив
     *
     * @return array|int|null
     */
    public function getAllBooks() {

        /** @var string $query строка запроса в БД */
        $query = $this->queryBuilder
            ->select()
            ->from('books')
            ->orderBy('id', 'DESC')
            ->sql();

        /** @var array $allBooks массив с данными всех книг из БД */
        $allBooks = $this->db->query($query);

        return $allBooks;
    }

    /**
     * Получает количество записей из таблицы БД, значение столбца coverUrl которых равно $url. Возвращает объект класса
     * stdClass, единственное свойство которого count содержит число выбранных из БД записей
     *
     * @param string $url
     * @return object объект с единственным свойством count - числом записей
     */
    public function getCountCoverUrls($url) {

        /** @var string $query строка запроса в БД */
        $query = $this->queryBuilder
            ->select('COUNT(*) as count')
            ->from('books')
            ->where('coverUrl', $url)
            ->sql();

        /** @var array $countCoverUrls массив результатов выборки */
        $countCoverUrls = $this->db->query($query, $this->queryBuilder->values);

        /** объект stdClass */
        return $countCoverUrls[0];
    }

    /**
     * Получает данные из БД по id книги и возвращает их как объект класса stdClass
     *
     * @param int $id id книги в БД
     * @return object|int|null объект, содержащий данные одной книги
     */
    public function getBookById($id) {

        /** @var $Book $book объект модели Book */
        $book = new Book($id);

        /** возвращает объект класса stdClass, имена свойств которого соответствуют именам полей таблицы 'books',
         *  а значения соответствуют значениям этих полей */
        return $book->findOne();
    }

    /**
     * Возвращает массив всех авторов из БД
     *
     * @return array|int|null
     */
    public function getAuthors() {

        /** @var string строка запроса в БД $getAuthors */
        $getAuthors = $this->queryBuilder
            ->select('author')
            ->from('books')
            ->sql();

        /** @var array $authors массив с именами всех авторов */
        $authors = $this->db->query($getAuthors);
        return $authors;
    }

    /**
     * Возвращает имя автора из БД по его идентификатору
     *
     * @param int $id id автора в БД
     * @return array|int|null
     */
    public function getCoverById($id) {

        /** @var string $queryString строка запроса в БД */
        $queryString = $this->queryBuilder
            ->select('coverUrl')
            ->from('books')
            ->where('id', $id)
            ->sql();

        /** @var array $url массив с одним элементом - путем к файлу обложки книги по его id */
        $url = $this->db->query($queryString, $this->queryBuilder->values);

        return $url;
    }

    /**
     * Добавляет дынные книги в БД
     *
     * @param array $data массив, данные которого будут записаны в БД
     */
    public function createBook($data) {

        /** @var Book $book объект модели книги */
        $book = new Book();

        //иницилизация свойств
        $book->setTitle($data['title'])
            ->setAuthor($data['author'])
            ->setYear($data['year'])
            ->setDescription($data['description'])
            ->setShortDescription($data['shortDescription'])
            ->setBookFileName($data['bookFileName'])
            ->setCategoryId($data['category']);

        if (isset($data['coverUrl'])) {//если был передан файл изображения из html формы

            //инициализировать свойство coverUrl объекта
            $book->setCoverUrl($data['coverUrl']);
        }

        /** @var int $bookId id вставленной записи */
        $bookId = $book->save();

        echo "Книга с идентификатором {$bookId} добавлена";

    }

    /**
     * Обновляе запись книги в БД
     *
     * @param array $params массив значений для вставки в БД
     */
    public function updateBook($params) {

        if (isset($params['bookId'])) {//если передан id записи, которую нужно обновить

            /** @var Book $book объект модели Book */
            $book = new Book($params['bookId']);

            //инициализация свойств
            $book->setTitle($params['title'])
                ->setAuthor($params['author'])
                ->setYear($params['year'])
                ->setDescription($params['description'])
                ->setShortDescription($params['shortDescription'])
                ->setCategoryId($params['category']);

            /** @var array $response массив, который будет запакован в json-строку и отправлен как ответ на запрос из
             * формы из шаблона edit.php. Строка будет распарсена в объект, который будет содержать следующие свойства:
             * message - сообщение после удачного добавления данных о книге в базу,
             * bookFileName - путь к файлу с книгой,
             * coverUrl - путь к файлу с изображением обложки
             */
            $response = [];

            //если передан указанный параметр - инициализировать указанное свойство
            if (isset($params['coverUrl'])) {
                $book->setCoverUrl($params['coverUrl']);
                $response['coverUrl'] = $params['coverUrl'];
            }

            //если передан указанный параметр - инициализировать указанное свойство
            if (isset($params['bookFileName'])){
                $book->setBookFileName($params['bookFileName']);
                $response['bookFileName'] = $params['bookFileName'];
            }

            //обновление записи
            $book->save();

            $response['message'] = "Книга с идентификатором {$params['bookId']} обновлена";

            $objResponse = json_encode($response);

            echo $objResponse;

            //echo "Книга с идентификатором {$params['bookId']} обновлена";
        }
    }

}