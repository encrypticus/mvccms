<?php

namespace Admin\Model\Page;

use Engine\Model;

/**
 * Class PageRepository содержит методы запросов в БД, работает с сущоностью модели Page
 * @package Admin\Model\Page
 */
class PageRepository extends Model {

    /**
     * @return array|int|null получает данные всех страниц из БД и возвращает их как массив
     */
    public function getPages() {

        $sql = $this->queryBuilder
            ->select()
            ->from('page')
            ->orderBy('id', 'DESC')
            ->sql();

        return $this->db->query($sql);
    }

    /**
     * Создает новую страницу в БД, возвращает идентификатор созданной страницы
     * @param $params массив с параметрами - заголовком и контентом статьи
     * @return int
     */
    public function createPage($params) {

        //новая страница
        $page = new Page();

        //установка заголовка и контента страницы
        $page->setTitle($params['pageTitle'])->setContent($params['pageContent']);

        //вставка новой записи в таблицу БД; переменная хранит идентификатор вставленной страницы
        $pageId = $page->save();

        //возврат id вставленной страницы
        return $pageId;
    }

    /**
     * Обновляет искомую по указанному id страницу в БД, возвращает идентификатор обновленной страницы
     * @param $params массив с параметрами - заголовком и контентом страницы
     * @return int
     */
    public function updatePage($params) {

        if (isset($params['pageId'])) {//если существует запись с искомым id

            //искомая страница с указанным в конструкторе идентификатором
            $page = new Page($params['pageId']);

            //установка обновленного заголовка и обновленного контента страницы
            $page->setTitle($params['pageTitle'])->setContent($params['pageContent']);

            //вставка новой записи в таблицу БД; переменная хранит идентификатор вставленной страницы
            $pageId = $page->save();

            //возврат id обновленной страницы
            return $pageId;
        }
    }

    //Получает одну страницу по идентификатору из БД
    public function getPageData($id) {

        //объект страницы
        $page = new Page($id);

        //массив с результатами одной записи из таблицы
        return $page->findOne();
    }
}