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

    public function getRandomCoverFullPath() {
        $this->setRandomName($this->getRandomFileName());
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