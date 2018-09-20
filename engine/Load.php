<?php
namespace Engine;
use Engine\DI\DI;
/**
 * Создает клас наследника класса Model - [modelEntity]Repository
 * Class Load
 * @package Engine
 */
class Load {
    /**
     * хранит строку с заполнителями для функции sprintf(). Строка хранит пространство имен класса [EntityName]Repository
     * (например UserRepository) - например \Admin\Model\User\UserRepository
     */
    const MASK_MODEL_REPOSITORY = '\%s\Model\%s\%sRepository';
    /**
     * @var \Engine\DI\DI di-контейнер
     */
    public $di;
    /**
     * Load constructor.
     * @param DI $di
     */
    public function __construct(DI $di) {
        $this->di = $di;
    }
    /**
     * Добавляет в di-контейнер зависимость 'model', значением которой является объект класса
     * \Admin\Model\[ModelName]\[ModelRepository], например \Admin\Model\Page\PageRepository
     * @param string $modelName имя класса сущности модели
     * @param bool $modelDir
     * @return bool
     */
    public function model($modelName, $modelDir = false) {
        // имя класса сущности модели
        $modelName = ucfirst($modelName);
        //если аргумент $modelDir передан - записать его значение в переменную
        $modelDir = $modelDir ? $modelDir : $modelName;
        /**
         * переменная будет содержать строку вида '\Admin\Model\[EntityDir]\[EntityRepository]'
         * или '\Cms\Model\[EntityDir]\[EntityRepository]', например \Admin\Model\Page\PageRepository
         */
        $namespaceModel = sprintf(
            self::MASK_MODEL_REPOSITORY,
            ENV, $modelDir, $modelName
        );
        //булева переменная - true, если класс с искомым именем существует, иначе false
        $isClassModel = class_exists($namespaceModel);
        //если существует такой класс, до добавить новую зависимость в DI-контейнер
        if ($isClassModel) {
            $modelRegistry = $this->di->get('model') ?: new \stdClass();
            $modelRegistry->{lcfirst($modelName)} = new $namespaceModel($this->di);
            $this->di->set('model', $modelRegistry);
        }
        return $isClassModel;
    }
}