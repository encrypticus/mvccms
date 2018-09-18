<?php
/**
 *Список роутов для админ-панели
 */

$this->router->add('login', '/admin/login/', 'LoginController:form');//страница с формой входа в админку

$this->router->add('dashboard', '/admin/', 'DashboardController:index');//главная страница админки

/**
 * контроллер содержит метод проверки, авторизован ли пользователь
 */
$this->router->add('auth-admin', '/admin/auth/', 'LoginController:authAdmin', 'POST');

$this->router->add('logout', '/admin/logout/', 'AdminController:logout');//контроллер содержит метод "разлогивания"

$this->router->add('pages', '/admin/pages/', 'PageController:listing');//отображение всех страниц

$this->router->add('page-create', '/admin/pages/create/', 'PageController:createPage');//страница создания страницы

/**
 * контроллер содержит метод, в котором осуществляется прием полей формы со страницы create.php, отправка которых
 * происходит при помощи xmlhttprequest
 */
$this->router->add('page-add', '/admin/page/add/', 'PageController:addPage', 'POST');

/**
 * контроллер содержит метод, в котором осуществляется прием полей формы со страницы edit.php, отправка которых
 * происходит при помощи xmlhttprequest
 */
$this->router->add('page-update', '/admin/page/update/', 'PageController:updatePage', 'POST');

$this->router->add('page-edit', '/admin/page/edit/(id:int)', 'PageController:edit');//страница редактирования страницы