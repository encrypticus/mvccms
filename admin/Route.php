<?php
/**
 *Список роутов для админ-панели
 */

$this->router->add('login', '/admin/login/', 'LoginController:form');//страница с формой входа в админку
$this->router->add('dashboard', '/admin/', 'DashboardController:index');//главная страница админки
$this->router->add('auth-admin', '/admin/auth/', 'LoginController:authAdmin', 'POST');
$this->router->add('logout', '/admin/logout/', 'AdminController:logout');