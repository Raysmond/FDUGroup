<?php
/**
 * SiteController class file.
 * @author: Raysmond
 */

class SiteController extends RController
{

    public $layout = "index";

    public $defaultAction = "index";

    public $userModel;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->userModel = new User();
    }

    public function actionIndex($params = null)
    {
        $users = $this->userModel->find();
        $this->render("index", $users, false);
    }

    public function actionView($params = null)
    {
        echo "<br/>action view executed by SiteController..<br/>";
        if ($params != null)
            print_r($params);
    }
}