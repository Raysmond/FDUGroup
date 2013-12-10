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

    public function actionIndex($params = null)
    {
        $this->setHeaderTitle("Welcome to FDUGroup");
        $this->render("index", array(), false);
    }

    public function actionAbout()
    {
        $this->setHeaderTitle("About FDUGroup");
        $this->render('about', null, false);
    }

    public function actionContact()
    {
        $this->setHeaderTitle("Contact with FDUGroup");
        $data = ['githubLink' => "https://github.com/Raysmond/FDUGroup"];

        $this->render('contact', $data, false);
    }

    public function actionHelp(){
        $this->setHeaderTitle("Site help");
        $data = array();
        $this->render('help',$data,false);
    }

    public function actionException(Exception $e){
        if(Rays::isAjax()){
            print $e;
            exit;
        }
        switch($e->getCode()){
            //case "404":
            //    $this->render("404",['message',$e->getMessage()]);
            //    break;
            default:
                $this->render("exception",['code'=>$e->getCode(),'message'=>$e->getMessage()]);
                print $e;
        }
    }
}