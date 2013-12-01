<?php
/**
 * SiteController class file.
 * @author: Raysmond
 */

class SiteController extends BaseController
{

    public $layout = "index";

    public $defaultAction = "index";

    public $userModel;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->userModel = new User();
    }

    public function beforeAction($action)
    {
        //$this->addJs("/public/js/customJs.js");
        //$this->addCss("/public/css/customCss.css");
        return parent::beforeAction($action);
    }

    /**
     * Home page
     * @param null $params
     */
    public function actionIndex($params = null)
    {
        $users = $this->userModel->find();
        $this->setHeaderTitle("Welcome to FDUGroup");
        $this->render("index", $users, false);
    }

    /**
     * View page
     * @param null $params
     */
    public function actionView($params = null)
    {
        echo "<br/>action view executed by SiteController..<br/>";
        if ($params != null)
            print_r($params);
        $this->setHeaderTitle("View Page");
    }

    /**
     * About page
     */
    public function actionAbout()
    {
        $this->setHeaderTitle("About FDUGroup");
        $this->render('about', null, false);
    }

    /**
     * Contact page
     */
    public function actionContact()
    {
        $this->setHeaderTitle("Contact with FDUGroup");
        $data = array(
            'githubLink' => "https://github.com/Raysmond/FDUGroup",
        );

        $this->render('contact', $data, false);
    }
}