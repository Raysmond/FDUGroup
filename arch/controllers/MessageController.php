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
    public function actionSend($receiverId)
    {
        $data = array();
        if($this->getHttpRequest()->isPostRequest()){
            $form = $_POST;
            $config = array(
                array('field'=>'content','label'=>'Content','rules'=>'trim|required'),
                array('field'=>'receiver_id','label'=>'Receiver','rules'=>'required'),
                array('field'=>'type','label'=>'Message type','rules'=>'trim|required'),
            );
            $validation = new RFormValidationHelper($config);
            if($validation->run()){
                $message = new Message();
                $senderId = 0;
                if(isset($_POST['sender'])){ //mainly for group and system message
                    $senderId = $_POST['sender'];
                }
                else{
                    $senderId = Rays::app()->getLoginUser()->id;
                }
                $title = isset($_POST['title'])?trim($_POST['title']):"";
                $message->sendMsg($_POST['type'],$senderId,$title,$_POST['content'],null,1);
                if(isset($message->id)&&$message->id!=''){
                    $this->flash("message","Send message successfully.");
                    $this->redirectAction('message','view');
                    return;
                }
                else{
                    $this->flash("message","Send message failed.");
                }
            }
            $data = array('messageForm'=>$form);
            if($validation->getErrors()!=''){
                $data['validation_errors'] = $validation->getErrors();
            }

        }
        $this->render('send',$data,false);
    }


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


    // $msgtype='all','unread','read'
    public function actionView($msgType='all')
    {
        if(Rays::app()->isUserLogin()){
            $messages = new Message();
            $userId = Rays::app()->getLoginUser()->id;
            if($msgType=='all'){
                $messages = $messages->getUserMsgs($userId);
            }
            else if($msgType=='read'){
                $messages = $messages->getReadMsgs($userId);
            }
            else if($msgType=='unread'){
                $messages = $messages->getUnReadMsgs($userId);
            }
            else{
                Rays::app()->page404();
                return;
            }
            $this->render('view',array('msgs'=>$messages,'type'=>$msgType),false);
        }
        else{
            $this->flash("message","Please login first.");
            $this->redirectAction('user','login');
            return;
        }
    }

}