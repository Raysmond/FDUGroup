<?php
/**
 * AdminController class file.
 * @author: Raysmond
 */

class AdminController extends BaseController{
    public $layout = 'admin';
    public $defaultAction = 'index';
    public $access = array(Role::ADMINISTRATOR=>array('index'));

    public function actionIndex()
    {
        $this->setHeaderTitle("Administration");
        $this->render('index');
    }
}