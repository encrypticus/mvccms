<?php
//список сервисов класса - используется в bootstrap.php для создания объектов сервисов
return [
    Engine\Service\Database\Provider::class,
    Engine\Service\Router\Provider::class,
    Engine\Service\View\Provider::class,
    Engine\Service\Config\Provider::class,
    Engine\Service\Request\Provider::class,
    Engine\Service\Load\Provider::class
];