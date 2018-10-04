<?php
//Список роутов для админ-панели

/** страница с формой входа в админку */
$this->router->add('login', '/admin/login/', 'LoginController:form');

/** главная страница админки */
$this->router->add('dashboard', '/admin/', 'DashboardController:index');

/** контроллер содержит метод проверки, авторизован ли пользователь */
$this->router->add('auth-admin', '/admin/auth/', 'LoginController:authAdmin', 'POST');

/** контроллер содержит метод "разлогинивания" */
$this->router->add('logout', '/admin/logout/', 'AdminController:logout');

/** отображение всех книг */
$this->router->add('books', '/admin/books/', 'BookController:listing');

/** страница добавления книги в БД */
$this->router->add('add-books', '/admin/books/addBook/', 'BookController:addBookPage');

/** страница добавления книги в БД */
$this->router->add('add-book-data', '/admin/books/addBookData/', 'BookController:addBookData', 'POST');

/** обновление книги в БД */
$this->router->add('edit-books', '/admin/books/editBookPage/(id:int)', 'BookController:editBookPage');

$this->router->add('edit-book-data', '/admin/books/editBookData/', 'BookController:editBookData', 'POST');