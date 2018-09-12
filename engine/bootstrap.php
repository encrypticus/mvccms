<?php

//путь к автозагрузчику классов
require_once __DIR__ . '/../vendor/autoload.php';

use Engine\Cms;
use Engine\DI\DI;

try {
    //контейнер dependency injection
    $di = new DI();

    //массив с списком сервисов
    $services = require_once __DIR__ . '/Config/Service.php';

    //создание всех присутствующих в массиве сервисов
    foreach ($services as $service) {
        $provider = new $service($di);
        $provider->init();
    }

    //объект cms
    $cms = new Cms($di);

    //запуск cms
    $cms->run();

} catch (\ErrorException $exception) {
    echo "$exception->getMessage()";
};