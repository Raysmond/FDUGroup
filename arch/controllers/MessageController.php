<?php
/**
 * MessageController class file.
 * @author: Raysmond
 */

class MessageController extends RController{
    public $layout = 'index';
    public $defaultAction = 'index';

    // to be implemented
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
        $message = new Message();
        $message->load($msgId);
        $message->type->load();

        $this->render('detail',array('message'=>$message),false);
    }

    // to be implemented
    public function actionSend()
    {
        if($this->getHttpRequest()->isPostRequest()){
            $form = $_POST;
            $validation = array(
                array('field'=>'content','label'=>'Content','rules'=>'trim|required')
            );
            
        }
    }

    // to be implemented
    public function actionRead($msgId)
    {
        if(!Rays::app()->isUserLogin()){
            $this->flash("message","Please login first.");
            $this->redirectAction('user','login');
            return;
        }
        $message = new Message();
        $message->markRead($msgId);
        $this->redirectAction('message','view', 'read');
    }

    // to be implemented
    // view my own messages
    // $msgtype='all','unread','read'
    public function actionView($msgtype='all')
    {
        if(Rays::app()->isUserLogin()){
            $msgs = new Message();
            $userId = Rays::app()->getLoginUser()->id;
            if($msgtype=='all'){
                $msgs = $msgs->getUserMsgs($userId);
            }
            else if($msgtype=='read'){
                $msgs = $msgs->getReadMsgs($userId);
            }
            else if($msgtype=='unread'){
                $msgs = $msgs->getUnReadMsgs($userId);
            }
            else{
                Rays::app()->page404();
                return;
            }
            $this->render('view',array('msgs'=>$msgs,'type'=>$msgtype),false);
        }
        else{
            $this->flash("message","Please login first.");
            $this->redirectAction('user','login');
            return;
        }
    }

}