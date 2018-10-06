<?php

namespace Engine\Core\FileLoader;

class CoverFileLoader extends FileLoader {

    /** @var string $coverDir директория по умолчанию для загружаемых файлов обложек книг */
    protected $coverDir = '/content/uploads/covers/';


    /**
     * Геттер для директории обложек
     * @return string
     */
    public function getCoverDir(): string {
        return $this->coverDir;
    }

    /**
     * Сеттер для директории обложек
     * @param string $coverDir
     */
    public function setCoverDir(string $coverDir) {
        $this->coverDir = $coverDir;
    }

    /**
     * Возвращает полный путь от корня файловой системы к файлу изображения обложки книги
     * @return string
     */
    public function getCoverFullPath() {
        return $_SERVER['DOCUMENT_ROOT'] . $this->getCoverDir() . $this->getFileName();
    }

    /**
     * Возвращает путь до файла с изображением обложки - 'sitename/content/uploads/covers/9d/0w/s98diujt79o7y6j.jpg'
     * @return string путь к изображению обложки книги
     */
    public function getRandomCoverFullPath() {
        /** @var string $path sitename + /content/uploads/covers/ + 9d/0w/ */
        $path = $_SERVER['DOCUMENT_ROOT'] . $this->getCoverDir() . $this->getDirsFromMdFile();

        //если не существует указанная структура каталогов, то создать её
        if(!file_exists($path)) mkdir($path, 0777, true);

        //записать в свойство this->randomName название файла изображения обложки
        $this->setRandomName($this->getRandomFileName());

        //вернуть путь до изображения
        return $_SERVER['DOCUMENT_ROOT'] . $this->getCoverDir() . $this->getRandomName();
    }

    /**
     * Проверяет - является ли загруженный файл во временном каталоге изображением. Если да, то возвращает true, иначе false
     * @return bool
     */
    public function isImageFile() {

        $fileInfo = new \finfo(FILEINFO_MIME_TYPE);

        $mime = $fileInfo->file($this->getTmpName());

        if(strpos($mime, 'image') === false) return false;

        return true;
    }

}