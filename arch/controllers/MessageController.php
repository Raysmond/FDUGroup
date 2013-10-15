<?php
/**
 * MessageController class file.
 * @author: Raysmond
 */

class MessageController extends RController{
    public $layout = 'index';
    public $defaultAction = 'index';

    public function actionDetail($msgId='')
    {
        if(Rays::app()->isUserLogin()==false){
            $this->flash('message',"Please login first.");
            $this->redirectAction('user','login');
            return false;
        }
        if($msgId==''){
            Rays::app()->page404();
            return false;
        }
    }

    public function actionSend()
    {
        if($this->getHttpRequest()->isPostRequest()){
            $form = $_POST;
            $validation = array(
                array('field'=>'content','label'=>'Content','rules'=>'trim|required')
            );
            
        }
    }
}