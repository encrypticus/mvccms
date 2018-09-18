<?php

namespace Admin\Controller;

/**
 * Class PageController класс контроллера - содержит методы работы со страницами: вывод списка всех страниц, отображение
 * страницы добавления страниц, метод обработки xmlHttpRequest-объекта(добавление страницы в БД) и др.
 * @package Admin\Controller
 */
class PageController extends AdminController {

    /**
     * отображает список всех страниц
     */
    public function listing() {

        //загрузка модели 'Page'
        $this->load->model('Page');

        //массив с данными всех страниц из БД
        $this->data['pages'] = $this->model->page->getPages();

        //отрисовка макета вывода всех страниц из БД и передача в него массива
        $this->view->render('pages/list', $this->data);
    }

    /**
     * отображает страницу создания страниц
     */
    public function createPage() {

        //отрисовка макета страницы для создания страниц
        $this->view->render('pages/create');
    }

    /**
     * добавляет страницу в БД
     */
    public function addPage() {

        //POST-массив
        $params = $this->request->post;

        //Загрузка модели 'Page'
        $this->load->model('Page');

        if (isset($params['pageTitle'])) {//если массив содержит указанное свойство

            //создать новую страницу в БД и результат записать в переменную
            $pageId = $this->model->page->createPage($params);

            echo $pageId;
        }

    }

    //Обновляет страницу в БД
    public function updatePage() {

        //POST-массив
        $params = $this->request->post;

        //Загрузка модели 'Page'
        $this->load->model('Page');

        if (isset($params['pageTitle'])) {//если массив содержит указанное свойство

            //обновить страницу в БД
            $this->model->page->updatePage($params);

            echo "Обновлена страница с идентификатором {$params['pageId']}";
        }
    }

    /**
     * Редактирует страницу в БД
     * @param $id идентификатор редактируемой статьи
     */
    public function edit($id) {

        //Загрузка модели 'Page'
        $this->load->model('Page');

        //массив с данными одной страницы из БД по идентификатору
        $this->data['page'] = $this->model->page->getPageData($id);

        //отрисовка макета страницы редактирования страниц и передача в него данных
        $this->view->render('pages/edit', $this->data);
    }

}