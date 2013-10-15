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
    // permissions should be considered
    public function actionSend($type)
    {
        if(!in_array($type,array('system','user','private','group')))
        {
            Rays::app()->page404();
            return;
        }

        $data = array('type'=>$type);

        if($this->getHttpRequest()->isPostRequest()){
            if(isset($_POST['new'])){
                if(isset($_POST['receiverName']))
                    $data['sendForm'] = array('receiver'=>$_POST['receiverName']);
                $this->render('send',$data,false);
                return;
            }

            $form = $_POST;

            $config = array(
                array('field'=>'title','label'=>'Title','rules'=>'trim|required'),
                array('field'=>'content','label'=>'Content','rules'=>'trim|required'),
                array('field'=>'receiver','label'=>'Receiver','rules'=>'required'),
                array('field'=>'type','label'=>'Message type','rules'=>'trim|required'),
            );

            $validation = new RFormValidationHelper($config);

            if($validation->run()){
                $receiver = new User();
                $receiver->name = $_POST['receiver'];
                $receiver = $receiver->find();
                if(empty($receiver)){
                    $this->flash("error","No such user.");
                }
                else
                {
                    $receiver = $receiver[0];
                    $message = new Message();
                    $senderId = 0;
                    if(isset($_POST['sender']))
                    { //mainly for group and system message
                        $senderId = $_POST['sender'];
                    }
                    else
                    {
                        $senderId = Rays::app()->getLoginUser()->id;
                    }

                    $title = isset($_POST['title'])?trim($_POST['title']):"";
                    $message->sendMsg($_POST['type'],$senderId,$receiver->id,$title,$_POST['content'],null,1);

                    if(isset($message->id)&&$message->id!='')
                    {
                        $this->flash("message","Send message successfully.");
                        $this->redirectAction('message','view');
                        return;
                    }
                    else
                    {
                        $this->flash("message","Send message failed.");
                    }
                }

            }

            $data['sendForm'] = $form;
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