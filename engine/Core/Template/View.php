<?php

namespace Engine\Core\Template;

use Engine\Core\Template\Theme;

/**
 * Класс вида
 * Class View
 * @package Engine\Core\Template
 */
class View {

    /**
     * @var \Engine\Core\Template\Theme объект темы
     */
    protected $theme;

    function __construct() {
        $this->theme = new Theme();
    }

    /**
     * Отображает переданный ей шаблон
     * @param string $template строка с именем файла шаблона
     * @param array $vars список передаваемых в шаблон параметров
     * @throws \Exception
     */
    public function render($template, $vars = []) {
        //путь к файлу шаблона
        $templatePath = $this->getTemplatePath($template, ENV);

        //выбросить исключение, если по данному пути нет искомого файла
        if (!is_file($templatePath)) {
            throw new \InvalidArgumentException(
                sprintf('Template "%s" not found in "%s"', $template, $templatePath)
            );
        }

        /**
         * Передача списка передаваемых в шаблон параметров объекту темы, так как напрямую из объекта темы к этим
         * параметрам обратиться нельзя
         */
        $this->theme->setData($vars);
        /**
         * Извлечь массив в переменные. Переменные создаются для того, чтобы к ним можно было обратиться в заданном шаблоне
         */
        extract($vars);


        //стартовать буфер обмена
        ob_start();
        ob_implicit_flush(0);

        try {
            //подключить файл по указанному пути
            require_once $templatePath;
        } catch (\Exception $exception) {
            ob_end_clean();
            throw $exception;
        }

        //вывести содержимое буфера (отобразить содержимое файла)
        echo ob_get_clean();
    }

    /**
     * В зависимости от переданного второго аргумента функция возвращает путь к пользовательскому шаблону или шаблону админки
     * @param string $template имя файла шаблона
     * @param string $env строка с именем окружения - 'Admin' или 'Cms'
     * @return string путь к файлу подключаемого шаблона
     */
    private function getTemplatePath($template, $env = null) {
        switch ($env) {
            case 'Admin':
                return ROOT_DIR . '/View/' . $template . '.php';
                break;
            case 'Cms':
                return ROOT_DIR . '/content/themes/default/' . $template . '.php';
                break;
            default:
                return ROOT_DIR . '/' . mb_strtolower($env) . '/View/' . $template . '.php';
        }

    }

}