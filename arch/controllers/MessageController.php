<?php
/**
 * MessageController class file.
 * @author: Raysmond
 */

class MessageController extends RController
{
    public $layout = 'user';
    public $defaultAction = 'index';
    public $access = array(
        Role::AUTHENTICATED => array('detail', 'send', 'read', 'view','delete','trash'),
        Role::ADMINISTRATOR => array('sendAdmin'),
    );

    // to be implemented
    public function actionDetail($msgId = '')
    {
        if ($msgId == '') {
            Rays::app()->page404();
            return false;
        }
        $message = new Message();
        $message->load($msgId);

        $loginId = Rays::app()->getLoginUser()->id;
        if ($message->receiverId != $loginId && $message->senderId != $loginId) {
            $this->flash("error", "Sorry. You don't have the right to read the message.");
            $this->redirectAction('message', 'view', 'all');
            return;
        }

        $message->type->load();

        $this->render('detail', array('message' => $message), false);
    }

    // to be implemented
    // permissions should be considered
    public function actionSend($type)
    {
        if (!in_array($type, array('system', 'user', 'private', 'group'))) {
            Rays::app()->page404();
            return;
        }

        $data = array('type' => $type);

        if ($this->getHttpRequest()->isPostRequest()) {
            if (isset($_POST['new'])) {
                if (isset($_POST['receiverName']))
                    $data['sendForm'] = array('receiver' => $_POST['receiverName']);
                $this->render('send', $data, false);
                return;
            }

            $form = $_POST;

            $config = array(
                array('field' => 'title', 'label' => 'Title', 'rules' => 'trim|required'),
                array('field' => 'msg-content', 'label' => 'Content', 'rules' => 'trim|required'),
                array('field' => 'receiver', 'label' => 'Receiver', 'rules' => 'required'),
                array('field' => 'type', 'label' => 'Message type', 'rules' => 'trim|required'),
            );

            $validation = new RFormValidationHelper($config);

            if ($validation->run()) {
                $receiver = new User();
                $receiver->name = $_POST['receiver'];
                $receiver = $receiver->find();
                if (empty($receiver)) {
                    $this->flash("error", "No such user.");
                } else {
                    $receiver = $receiver[0];
                    $message = new Message();
                    $senderId = 0;
                    if (isset($_POST['sender'])) { //mainly for group and system message
                        $senderId = $_POST['sender'];
                    } else {
                        $senderId = Rays::app()->getLoginUser()->id;
                    }

                    $title = isset($_POST['title']) ? trim($_POST['title']) : "";
                    $msgContent = RHtmlHelper::encode($_POST['msg-content']);
                    $message->sendMsg($_POST['type'], $senderId, $receiver->id, $title, $msgContent, null, 1);

                    if (isset($message->id) && $message->id != '') {
                        $this->flash("message", "Send message successfully.");
                        $this->redirectAction('message', 'view');
                        return;
                    } else {
                        $this->flash("message", "Send message failed.");
                    }
                }

            }

            $data['sendForm'] = $form;
            if ($validation->getErrors() != '') {
                $data['validation_errors'] = $validation->getErrors();
            }

        }

        $this->render('send', $data, false);
    }


    public function actionRead($msgId)
    {
        $referrer = $this->getHttpRequest()->getUrlReferrer();
        $message = new Message();
        $message = $message->load($msgId);
        if (Rays::app()->getLoginUser()->id != $message->receiverId) {
            $this->flash("error", "Sorry. You don't have the right to mark the message read.");
        }
        $message->markRead($msgId);
        $this->redirect($referrer);
    }


    /**
     * View messages
     * @access authenticated user
     * @param string $msgType
     */
    public function actionView($msgType = 'all')
    {
        $this->setHeaderTitle("Messages");
        $messages = new Message();
        $userId = Rays::app()->getLoginUser()->id;
        switch($msgType){
            case "all":
                $messages = $messages->getUserMsgs($userId);
                break;
            case "read":
                $messages = $messages->getReadMsgs($userId);
                break;
            case "unread":
                $messages = $messages->getUnReadMsgs($userId);
                break;
            //case "send":
            //    $messages = $messages->getUserSentMsgs($userId);
            //    break;
            case "trash":
                $messages = $messages->getTrashMsgs($userId);
                break;
            default:
                Rays::app()->page404();
                return;
        }
        if($messages==null) $messages = array();
        $this->render('view', array('msgs' => $messages, 'type' => $msgType), false);
    }

    public function actionTrash($msgId)
    {
        if (isset($msgId) && is_numeric($msgId)) {
            $msg = new Message();
            $msg = $msg->load($msgId);
            if ($msg != null && $msg->receiverId == Rays::app()->getLoginUser()->id) {
                $msg->markTrash($msgId);
            }
        }
        $this->redirect($this->getHttpRequest()->getUrlReferrer());
    }

    public function actionDelete($msgId)
    {
        if (isset($msgId) && is_numeric($msgId)) {
            $msg = new Message();
            $msg = $msg->load($msgId);
            $user = Rays::app()->getLoginUser();
            if ($msg != null && ($msg->receiverId == $user->id || $user->isAdmin())) {
                $msg->delete();
            }
        }
        $this->redirect($this->getHttpRequest()->getUrlReferrer());
    }

    public function actionSendAdmin()
    {
        $this->layout = 'admin';
        $this->actionSend('system');
    }
}