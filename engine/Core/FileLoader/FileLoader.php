<?php

namespace Engine\Core\FileLoader;

/**
 * Class FileLoader Класс для работы с загружаемыми на сервер файлами
 */
class FileLoader {

    protected $fileName;//имя загружаемого на сервер файла до его отправки на сервер

    protected $type;//MIME-тип загруженного файла

    protected $size;//размер загруженного файла в байтах

    protected $tmpName;//имя файла во временном каталоге на сервере

    protected $error;//код ошибки, которая может возникнуть при загрузке файла

    protected $randomName = '';//случайно генерируемое имя заруженного файла

    /**
     * FileLoader constructor.
     * @param string $file имя загружаемого на сервер файла; строка, значение которой берется из
     * атрибута name тега input (поле выбора файла) из файла add_content_form.html
     */
    function __construct($file = '') {
        $this->fileName = $_FILES[$file]['name'];//имя загружаемого на сервер файла до его отправки на сервер

        $this->type = $_FILES[$file]['type'];//MIME-тип загруженного файла

        $this->size = $_FILES[$file]['size'];//размер загруженного файла в байтах

        $this->tmpName = $_FILES[$file]['tmp_name'];//имя файла во временном каталоге на сервере

        $this->error = $_FILES[$file]['error'];//код ошибки, которая может возникнуть при загрузке файла
    }

    /**
     * Кладет загружаемый файл по пути $path
     * @param string $path директория ( полный путь - название директории + имя файла ), в которую будет окончательно
     * положен из временного каталога загружаемый файл
     */
    public function moveUploadedFile($path) {
        copy($this->tmpName, $path);
    }


    /**
     * @return string
     */
    public function getRandomName(): string {
        return $this->randomName;
    }

    /**
     * @param string $randomName
     */
    public function setRandomName(string $randomName) {
        $this->randomName = $randomName;
    }

    /**
     * Возвращает имя загружаемого на сервер файла
     * @return string имя файла до его отправки на сервер
     */
    public function getFileName() {
        return $this->translit($this->fileName);
    }

    /**
     * Получение md5 строки содержимого файла
     * @return string
     */
    public function getMdFromFile() {
        return md5_file($this->tmpName);
    }

    /**
     * Получение md5 строки имени файла
     * @return string
     */
    public function getMdFromName() {
        return md5($this->fileName . microtime() . rand(0, 9999));
    }

    public function getRandomFileName() {
        return $this->getMdFromFile() . '.' . $this->getFileExtension();
    }

    /**
     * Возвращает MIME-тип загружаемого на сервер файла
     * @return string MIME-тип загружаемого на сервер файла
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Возвращает размер загружаемого на сервер файла
     * @return string размер загружаемого на сервер файла
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Возвращает имя загруженного файла во временном каталоге на сервере
     * @return string имя загруженного файла во временном каталоге на сервере
     */
    public function getTmpName() {
        return $this->tmpName;
    }

    /**
     * Читает содержимое файла
     * @param string $content путь к файлу, который следует прочитать
     * @return bool|string возвращает прочтенные данные, или false в случае возникновения ошибки при чтении файла
     */
    public function getContent($content = 'default') {
        return file_get_contents($content);
    }

    /**
     * @param $string string подлежащая транслитерации строка
     * @return string
     */
    public function translit($string) {
        $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            "’" =>'\''
        );
        return strtr($string, $converter);
    }

    /**
     * Возвращает расширение загруженного во временную директорию файла
     * @return string
     */
    public function getFileExtension() {
        return pathinfo($this->getFileName(), PATHINFO_EXTENSION);
    }

}