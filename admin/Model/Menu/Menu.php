<?php

namespace Admin\Model\Menu;


use Engine\Core\Database\ActiveRecord;

class Menu {
    use ActiveRecord;//класс использует этот трейт

    /**
     * @var string имя таблицы базы данных
     */
    protected $table = 'menu';

    /**
     * @var int id идентификатор категории в базе
     */
    public $category_id;

    /**
     * @var string название категории в базе
     */
    public $name;

    /**
     * @return int
     */
    public function getCategoryId(): int {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     */
    public function setCategoryId(int $category_id) {
        $this->category_id = $category_id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) {
        $this->name = $name;
    }

}