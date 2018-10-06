<?php

namespace Admin\Controller;

use Engine\Core\FileLoader\BookFileLoader;
use Engine\Core\FileLoader\CoverFileLoader;
use Engine\Helper\FormChecker;

/**
 * Содержит методы отображения в админке списка всех содержащихся в БД книг, добавления данных книг в БД, отображения страницы
 * добавления книг в БД
 *
 * Class BookController
 * @package Admin\Controller
 */
class BookController extends AdminController {

    /**
     * Отображает список всех книг
     */
    public function listing() {

        //загрузка модели 'Book'
        $this->load->model('Book');

        //загрузка модели меню
        $this->load->model('Menu');

        /** @var  string[] $data массив с данными всех категорий из БД */
        $data['categories'] = $this->model->menu->getItems();

        /** @var string[] $data массив с данными всех книг из БД */
        $data['books'] = $this->model->book->getAllBooks();

        //отрисовка шаблона вывода всех страниц из БД и передача в него массива
        $this->view->render('books/list', $data);
    }

    /**
     * Отображает страницу добавления страниц в БД
     */
    public function addBookPage() {

        //загрузка модели 'Menu'
        $this->load->model('Menu');

        /** @var string[] $data массив с данными списка меню из БД */
        $data['items'] = $this->model->menu->getItems();

        //отрисовка шаблона страницы и передача в него массива данных
        $this->view->render('books/add', $data);
    }

    /**
     * Добавляет данные книги в БД
     * Обрабатывает ajax-запрос из шаблона add.php. Возвращает либо false при возникновении ошибки, либо сообщение вида
     * "Книга с идентификатором 5 добавлена"
     *
     * @return bool|string
     */
    public function addBookData() {

        /** @var array $params POST массив со значениями формы из шаблона add.php */
        $params = $this->request->post;

        /** @var array $files FILES-массив со значениями формы из шаблона add.php */
        $files = $this->request->files;

        //Проверка полей формы на пустоту и установка соответствующих сообщений
        FormChecker::checkFields([
            $params['title'],
            $params['author'],
            $params['year'],
            $params['description'],
            $params['shortDescription']
        ],
            ['Название книги не может быть пустым',
                'Имя автора не может быть пустым',
                'Год издания не может быть пустым',
                'Описание не может быть пустым',
                'Краткое описание не может быть пустым'
            ]
        );

        //если не выбран файл книги, добавить в массив сообщение об ошибке
        if (FormChecker::bookFileNotUpload($files['bookFile']['size'])) {
            FormChecker::setError('Не выбран файл книги');
        }

        //Если в массиве присутствуют ошибки - вывести соответствующие сообщение и прервать выполнение
        if (FormChecker::issetErrors()) return false;

        /**
         * массив, который будет содержать ключи 'bookFileName' и 'coverUrl' - строку со значением пути вместе с именем
         * файла и строку со значением пути к файлу изображения обложки книги соответственно
         *
         * @var array $fileData
         */
        $fileData = [];

        //если файл обложки книги был передан из html формы
        if (FormChecker::fileUpload($files['cover']['size'])) {

            /** @var CoverFileLoader $coverLoader объект загрузчика файла обложки */
            $coverLoader = new CoverFileLoader('cover');

            if (!$coverLoader->isImageFile()) {//если это не файл изображения

                //добавить в массив сообщение об ошибке
                FormChecker::setError('Неверный файл изображения');

                //отобразить имеющиеся ошибки
                FormChecker::displayErrors();

                //прервать выполнение
                return false;
            }

            //перемещение загруженного файла обложки книги из временной директории в указанный католог
            $coverLoader->moveUploadedFile($coverLoader->getRandomCoverFullPath());

            /** @var  string $fileData конечный путь загруженного файла обложки книги без доменного имени (для записи в БД),
             * который будет вставлен в атрибут src тега img в шаблоне list.php
             */
            $fileData['coverUrl'] = $coverLoader->getCoverDir() . $coverLoader->getRandomName();
        }

        /** @var BookFileLoader $bookLoader объект загрузчика файла книги */
        $bookLoader = new BookFileLoader('bookFile');

        //загрузка модели 'Menu'
        $this->load->model('Menu');

        /** @var string $categoryName имя категории из POST-массива */
        $categoryName = $this->model->menu->getCategoryNameById($params['category']);

        //перемещение загруженного файла книги из временной директории в указанный католог
        $bookLoader->moveUploadedFile($bookLoader->getFileFullPath($categoryName));

        /** @var string $fileData конечный путь загруженного файла книги без доменного имени (для записи в БД),
         * который будет вставлен в атрибут href тега <a> в шаблоне list.php
         */
        $fileData['bookFileName'] = $bookLoader->getFileFullPath($categoryName, false);

        /** удаление пробелов из значений POST-массива */
        foreach ($params as $param => $value) {
            $params[$param] = trim($value);
        }

        /** @var array $data объединенный массив */
        $data = array_merge($params, $fileData);

        //загрузка модели 'Book'
        $this->load->model('Book');

        //Добавление книги в БД
        $this->model->book->createBook($data);
    }

    /**
     * Обновляет данные книги в БД
     *
     * @param int $bookId id книги из БД
     */
    public function editBookPage($bookId) {

        //загрузка модели 'Menu'
        $this->load->model('Menu');

        /** @var string[] $data массив с данными списка меню из БД */
        $this->data['items'] = $this->model->menu->getItems();

        //загрузка модели 'Book'
        $this->load->model('Book');

        $this->data['book'] = $this->model->book->getBookById($bookId);

        //отрисовка шаблона страницы и передача в него массива данных
        $this->view->render('books/edit', $this->data);
    }

    /**
     * Обновляет данные книги в БД
     *
     * Обрабатывает ajax-запрос из шаблона edit.php. Возвращает либо false при возникновении ошибки, либо сообщение вида
     * "Книга с идентификатором 5 обновлена"
     *
     * @return bool|string
     */
    public function editBookData() {

        /** @var array $params POST массив со значениями формы из шаблона add.php */
        $params = $this->request->post;

        /** @var array $files FILES-массив со значениями формы из шаблона add.php */
        $files = $this->request->files;

        //Проверка полей формы на пустоту и установка соответствующих сообщений, если указанные поля пусты
        FormChecker::checkFields([
            $params['title'], //поле заголовка
            $params['author'], //поле имени автора
            $params['year'], //поле года издания
            $params['description'], //поле описания
            $params['shortDescription'] //поле краткого описания
        ],
            ['Название книги не может быть пустым', //если поле названия книги пустое
                'Имя автора не может быть пустым', //если поле имени автора книги пустое
                'Год издания не может быть пустым', //если поле года издания книги пустое
                'Описание не может быть пустым', //если поле описания книги пустое
                'Краткое описание не может быть пустым' //если поле краткого описания книги пустое
            ]
        );

        //Если в массиве присутствуют ошибки - вывести соответствующие сообщения и прервать выполнение
        if (FormChecker::issetErrors()) return false;

        /**
         * массив, который будет содержать ключи 'bookFileName' и 'coverUrl' - строку со значением пути вместе с именем
         * файла и строку со значением пути к файлу изображения обложки книги соответственно
         *
         * @var array $fileData
         */
        $fileData = [];

        //загрузка модели 'Book'
        $this->load->model('Book');


        /** @var object $bookData объект, содержащий данные книги по ее id */
        $bookData = $this->model->book->getBookById($params['bookId']);

        if (FormChecker::fileUpload($files['cover']['size'])) {//если файл изображения обложки был загружен из формы

            /** @var CoverFileLoader $coverLoader объект загрузчика файла обложки */
            $coverLoader = new CoverFileLoader('cover');

            /** @var string $oldCoverUrl текущий путь к файлу обложки книги */
            $oldCoverUrl = $_SERVER['DOCUMENT_ROOT'] . $bookData->coverUrl;

            if (!$coverLoader->isImageFile($coverLoader->getTmpName())) {//если это не файл изображения

                //добавить в массив сообщение об ошибке
                FormChecker::setError('Неверный файл изображения');

                //отобразить имеющиеся ошибки
                FormChecker::displayErrors();

                //прервать выполнение
                return false;
            }

            /*if($coverLoader->getMdFromFile() == md5_file($oldCoverUrl)) {//если файл был загружен ранее

                //добавить в массив сообщение об ошибке
                FormChecker::setError('Изображение было загружено ранее');

                //отобразить имеющиеся ошибки
                FormChecker::displayErrors();

                //прервать выполнение
                return false;
            }*/

            /** @var int $countCoverUrls число книг(записей) из БД, которые имеют одинаковый путь к файлу обложки,
             * то-есть ссылаются на один и тот же файл изображения */
            $countCoverUrls = $this->model->book->getCountCoverUrls($bookData->coverUrl);

            /** @var bool $isNotDefaultCover указывает, равен ли текущий путь к файлу изображения пути по умолчанию */
            $isNotDefaultCover = $bookData->coverUrl != $coverLoader->getCoverDir() . 'default.jpg';

            /** если на файл изображения обложки не ссылаются хотя бы две книги из БД и это не файл изображения по умолчанию */
            if ($countCoverUrls->count < 2 and $isNotDefaultCover) {

                /** @var string $dir1 полный путь до директории с файлом обложки вида 'sitename/uploads/covers/u8/9f' */
                $dir1 = pathinfo($oldCoverUrl)['dirname'];

                /** @var string $dir2 полный путь до директории уровнем выше директории $dir1 с файлом обложки вида 'sitename/uploads/covers/u8' */
                $dir2 = substr($dir1, 0, -3);

                //рекурсивно удалить файл и созданные при его загрузке содержащие его вложенные директории
                $coverLoader->removeDirRecursive($dir2);
            }

            //перемещение загруженного файла обложки книги из временной директории в указанный католог
            $coverLoader->moveUploadedFile($coverLoader->getRandomCoverFullPath());

            /** @var  string $fileData конечный путь загруженного файла обложки книги без доменного имени (для записи в БД),
             * который будет вставлен в атрибут src тега img в шаблоне list.php
             */
            $fileData['coverUrl'] = $coverLoader->getCoverDir() . $coverLoader->getRandomName();
        }

        if (FormChecker::fileUpload($files['bookFile']['size'])) {//если файл книги был загружен из формы

            /** @var BookFileLoader $bookLoader объект загрузчика файла книги */
            $bookLoader = new BookFileLoader('bookFile');

            /** @var string $oldFile старое (тукущее) имя файла книги в БД включая корень, имя директории и имя файла */
            $oldFile = $_SERVER['DOCUMENT_ROOT'] . $bookData->bookFileName;

            if (unlink($oldFile)) {//Удалить указанный файл, и если он удален

                //загрузка модели 'Menu'
                $this->load->model('Menu');

                /** @var string $categoryName имя категории из POST-массива */
                $categoryName = $this->model->menu->getCategoryNameById($params['category']);

                //перемещение загруженного файла книги из временной директории в указанный католог
                $bookLoader->moveUploadedFile($bookLoader->getFileFullPath($categoryName));

                /** @var string $fileData конечный путь загруженного файла книги без доменного имени (для записи в БД),
                 * который будет вставлен в атрибут href тега <a> в шаблоне list.php
                 */
                $fileData['bookFileName'] = $bookLoader->getFileFullPath($categoryName, false);
            }
        } else {//если же файл книги не был загружен из формы

            /** @var int $currentCategory id текущей категории в БД */
            $currentCategory = $bookData->categoryId;

            /** @var BookFileLoader $bookLoader объект файлозагрузчика */
            $bookLoader = new BookFileLoader();

            //если переданный из формы id категории не равен id, записанному в текущий момент в БД, то-есть в форме отправки
            //была изменена категория книги
            if ($params['category'] != $currentCategory) {

                /** @var string $oldFile строка, содержащая тукущий путь к файлу книги с корнем, директорией книги и
                 * названием книги */
                $oldFile = $_SERVER['DOCUMENT_ROOT'] . $bookData->bookFileName;

                //загрузка модели 'Menu'
                $this->load->model('Menu');

                /** @var string $oldCategoryName строка, содержащая текущее имя категории */
                $oldCategoryName = $this->model->menu->getCategoryNameById($currentCategory);

                /** @var string $oldCategoryName транслитерированая строка, содержащая текущее имя категории */
                $oldCategoryName = $bookLoader->translit($oldCategoryName);

                /** @var string $categoryName имя категории из POST-массива */
                $newCategoryName = $this->model->menu->getCategoryNameById($params['category']);

                /** @var string $categoryName транслитерированое имя категории из POST-массива */
                $newCategoryName = $bookLoader->translit($newCategoryName);

                /** @var string $newFile строка, содержащая новый путь к файлу книги с корнем, директорией книги и
                 * названием книги */
                $newFile = preg_replace('#' . $oldCategoryName . '#', $newCategoryName, $oldFile, 1);

                /** запись имени файла книги в $fileName[1] */
                preg_match('#/' . $oldCategoryName . '/(.+)#', $bookData->bookFileName, $fileName);

                if (file_exists($oldFile)) {//если файл по указанному текущему пути существует

                    //если не существует директории указанной категории, то создать ее
                    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $bookLoader->getFileDir() . $newCategoryName)) {
                        $bookLoader->mkDir($newCategoryName);
                    }

                    if (rename($oldFile, $newFile)) {//если переименование возможно, то переименовать и выполнить следующее

                        /** @var string $fileData конечный путь загруженного файла книги без доменного имени (для записи в БД),
                         * который будет вставлен в атрибут href тега <a> в шаблоне list.php */
                        $fileData['bookFileName'] = $bookLoader->getFileDir() . $newCategoryName . '/' . $fileName[1];
                    }
                }
            }
        }

        $data = array_merge($params, $fileData);

        $this->model->book->updateBook($data);
    }
}