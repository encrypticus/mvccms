<?php

namespace Engine\Core\FileLoader;

class BookFileLoader extends FileLoader {

    /** @var string $fileDir директория по умолчанию для загружаемых файлов книг */
    protected $fileDir = '/content/uploads/files/';

    /**
     * Геттер для директории файлов
     * @return string
     */
    public function getFileDir(): string {
        return $this->fileDir;
    }

    /**
     * Сеттер для директории файлов
     * @param string $fileDir
     */
    public function setFileDir(string $fileDir) {
        $this->fileDir = $fileDir;
    }

    /**
     * Возвращает танслитерированное имя категории книги
     *
     * @param  string $categoryName имя категории книги
     * @return string
     */
    public function getCategoryName($categoryName) {
        return $this->translit($categoryName);
    }

    /**
     * Возвращает полный путь от корня файловой системы или путь без доменного имени к файлу книги ( в зависимости от значения
     * второго параметра )
     *
     * Если вторым аргумент передан true, то будет возвращен файловый путь к книге вида "доменное имя/имя каталога
     * для файлов книг/имя каталога, соответствующее имени категории загруженного файла/имя самого файла книги с расширением -
     * то-есть полный путь от корня до файла. Если же передан аргумент false - то путь будет иметь вид - /имя каталога
     * для файлов книг/имя каталога, соответствующее имени категории загруженного файла/имя самого файла книги с расширением,
     * то-есть путь к файлу без доменного имени. Первый вариант необходим для передачи пути в классе BookController для
     * перемещения загруженного на сервер файла книги по указанному пути . Второй вариант нужен для передачи пути в этом же
     * классе для для записи строкового значения пути в БД, которое будет вставлено в атрибут href тега <a> в шаблоне list.php
     *
     * @param $categoryName имя категории книги
     *
     * @param bool $root
     *
     * @return string
     */
    public function getFileFullPath($categoryName, $root = true) {

        /** @var string $categoryName танслитерированное имя категории книги */
        $categoryName = $this->getCategoryName($categoryName);

        /** @var string $pathToDir путь к каталогу на сервере вместе с именем категории, по которому лежат файлы книг */
        $pathToDir = $root ? $_SERVER['DOCUMENT_ROOT'] . $this->getFileDir() . $categoryName : $this->getFileDir() . $categoryName;

        //если каталога с указанным именем не существует, то создать его
        if($root) if (!file_exists($pathToDir)) mkdir($pathToDir, 0777);

        return $pathToDir . "/" . $this->getFileName();
    }

    public function mkDir($dir) {
        mkdir($_SERVER['DOCUMENT_ROOT'] . $this->getFileDir() . $dir);
    }

}