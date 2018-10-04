<?php

namespace Admin\Model\Menu;

use Engine\Model;

/**
 * Класс-наследник класса Model. Содержит методы работы с сущностью 'Menu'
 * Class MenuRepository
 * @package Admin\Model\Menu
 */
class MenuRepository extends Model {

    /**
     * Возвращает массив, каждый элемент которого содержит запись категории из БД
     * @return array|int|null
     */
    public function getItems() {

        $sql = $this->queryBuilder
            ->select()
            ->from('menu')
            ->sql();

        $items = $this->db->query($sql);

        return $items;
    }

    /**
     * Возвращает имя категории
     *
     * @param $id
     * @return string
     */
    function getCategoryNameById($id) {

        /** @var string $sql строка запроса в БД */
        $sql = $this->queryBuilder
            ->select('name')
            ->from('menu')
            ->where('category_id', $id)
            ->sql();

        /** @var array $categoryName массив с одним элементом - объектом класса stdClass с единственным свойством name -
         * именем категории
         */
        $categoryName = $this->db->query($sql, $this->queryBuilder->values);

        return $categoryName[0]->name;
    }

}