<?php
namespace Admin\Controller;

/**
 * Class DashboardController контроллер отображает главную страницу админки
 * @package Admin\Controller
 */
class DashboardController extends AdminController {

    //вывод главной страницы админки
    public function index() {

        $this->view->render('dashboard');
    }
}