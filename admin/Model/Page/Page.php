<?php

namespace Admin\Model\Page;

use Engine\Core\Database\ActiveRecord;

/**
 * Class Page класс модели сущнсти страницы
 * @package Admin\Model\Page
 */
class Page {

    use ActiveRecord;

    /**
     * @var string имя таблицы в БД
     */
    protected $table = 'page';

    /**
     * @var int id идентификатор страницы в БД
     */
    public $id;

    /**
     * @var string title заголовок статьи в БД
     */
    public $title;

    /**
     * @var string content содержимое статьи в БД
     */
    public $content;

    /**
     * @var string дата публикации статьи
     */
    public $date;

    /* Геттеры и сеттеры свойств */

    /**
     * @return mixed
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param $date
     * @return $this
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param $content
     * @return $this
     */
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

}