<?php
namespace Engine\Core\Template;
class Theme {
    /**
     * Константа содержит список шаблонов для подключения в функциях header(), footer(), block() соответствующих шаблонов по
     * переданному имени. Значения используются в этих функциях для подстановки в функции sprintf
     */
    const RULES_NAME_FILE = [
        'header' => 'header-%s',
        'sidebar' => 'sidebar-s%',
        'footer' => 'footer-s%'
    ];
    /**
     * @var string
     */
    public $url = '';
    /**
     * @var array список параметров объекта вида, передаваемых в объект темы
     */
    protected $data = [];
    /**
     * Устанавливает список параметров
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = $data;
    }
    /**
     * Возвращает список параметров
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }
    /**
     * Загружает и отображает шапку шаблона темы
     * @param string $name имя файла шаблона шапки
     */
    public function header($name = null) {
        //привидиние имени к строке
        $name = (string) $name;
        //если аргумент $name передан - присвоить переменной $file имя переданного аргумента, иначе присвоить значение
        //по умолчанию
        $file = $name !== '' ? sprintf(self::RULES_NAME_FILE['header'], $name) : 'header';
        //загрузить файл шаблона по полученному имени
        $this->loadTemplateFile($file);
    }
    /**
     * Загружает и отображает футер шаблона темы
     * @param string $name имя файла шаблона футера
     */
    public function footer($name = '') {
        //привидение имени к строке
        $name = (string) $name;
        //если аргумент $name передан - присвоить переменной $file имя переданного аргумента, иначе присвоить значение
        //по умолчанию
        $file = $name !== '' ? sprintf(self::RULES_NAME_FILE['footer'], $name) : 'footer';
        //загрузить файл шаблона по полученному имени
        $this->loadTemplateFile($file);
    }
    /**
     * Загружает и отображает сайдбар шаблона темы
     * @param string $name имя файла шаблона сайдбара
     */
    public function sidebar($name = '') {
        //привидение имени к строке
        $name = (string) $name;
        //если аргумент $name передан - присвоить переменной $file имя переданного аргумента, иначе присвоить значение
        //по умолчанию
        $file = $name !== '' ? sprintf(self::RULES_NAME_FILE['sidebar'], $name) : 'sidebar';
        //загрузить файл шаблона по полученному имени
        $this->loadTemplateFile($file);
    }
    /**
     * Загружает и отображает блок шаблона темы
     * @param string $name имя файла шаблона блока
     * @param array $data передаваемые данные
     */
    public function block($name = '', $data = []) {
        //привидение имени к строке
        $name = (string) $name;
        //загрузить файл шаблона блока, если он был передан
        if($name !== '') {
            $this->loadTemplateFile($name, $data);
        }
    }
    /**
     * Подключает файл шаблона по переданному имени
     * @param $fileName имя файла шаблона
     * @param array $data передаваемые в шаблон данные
     * @throws \Exception
     */
    private function loadTemplateFile($fileName, $data = []) {
        //путь к файлу шаблона
        $templateFile = ROOT_DIR . "/content/themes/default/{$fileName}.php";
        if(ENV == 'Admin') {// путь к файлу шаблона для админки
            $templateFile = ROOT_DIR . "/View/{$fileName}.php";
        }
        if (is_file($templateFile)) {//если по указанному пути лежит файл
            //извлечь переданные данные в переменные
            extract(array_merge($data, $this->data));
            //и подключить файл шаблона
            require_once $templateFile;
        } else {//иначе выбросить исключение
            throw new \Exception(
                sprintf('Не удается найти файл %s', $templateFile)
            );
        }
    }
}