<?php

namespace Engine;

/**
 * Создает клас наследника класса Model - [modelEntity]Repository
 * Class Load
 * @package Engine
 */
class Load {

    /**
     * хранит строку с заполнителями для функции sprintf(). Строка хранит пространство имен класса сущности модели (например
     * 'User' ) например \Admin\Model\User\User
     */
    const MASK_MODEL_ENTITY = '\%s\Model\%s\%s';

    /**
     * хранит строку с заполнителями для функции sprintf(). Строка хранит пространство имен класса [EntityName]Repository
     * (например UserRepository) - например \Admin\Model\User\UserRepository
     */
    const MASK_MODEL_REPOSITORY = '\%s\Model\%s\%sRepository';

    /**
     * Создает и возвращает объект, содержащий два свойства: entity и repository. Первое свойство хранит строку с пространством
     *  имен класса сущности модели - например '\Admin\Model\User\User'. Второе - объект класса [EntityName]Repository
     * @param string $modelName имя класса сущности модели
     * @param bool $modelDir
     * @return \stdClass
     */
    public function model($modelName, $modelDir = false) {
        // объект di-контейнера
        global $di;

        // имя класса сущности модели
        $modelName = ucfirst($modelName);
        // пустой объект
        $model = new \stdClass();
        //если аргумент $modelDir передан - записать его значение в переменную
        $modelDir = $modelDir ? $modelDir : $modelName;

        /**
         * переменная будет содержать строку вида '\Admin\Model\[EntityDir]\[EntityName]'
         * или '\Cms\Model\[EntityDir]\[EntityName]'
         */
        $namespaceEntity = sprintf(
            self::MASK_MODEL_ENTITY,
            ENV, $modelDir, $modelName
        );

        /**
         * переменная будет содержать строку вида '\Admin\Model\[EntityDir]\[EntityRepository]'
         * или '\Cms\Model\[EntityDir]\[EntityRepository]'
         */
        $namespaceRepository = sprintf(
            self::MASK_MODEL_REPOSITORY,
            ENV, $modelDir, $modelName
        );

        // стррока вида, например, // Admin\Model\User\User
        $model->entity = $namespaceEntity;
        // объект вида, например, new Admin\Model\User\UserRepository()
        $model->repository = new $namespaceRepository($di);

        return $model;
    }
}