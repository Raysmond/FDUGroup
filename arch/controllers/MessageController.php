<?php
/**
 * MessageController class file.
 * @author: Raysmond
 */

class MessageController extends RController
{
    public $layout = 'index';
    public $defaultAction = 'index';
    public $access = array(Role::AUTHENTICATED => array('detail', 'send', 'read', 'view'));

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
                array('field' => 'content', 'label' => 'Content', 'rules' => 'trim|required'),
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
                    $message->sendMsg($_POST['type'], $senderId, $receiver->id, $title, $_POST['content'], null, 1);

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


    // to be implemented
    public function actionRead($msgId)
    {
        $message = new Message();
        $message->load($msgId);
        if (Rays::app()->getLoginUser()->id != $message->receiverId) {
            $this->flash("error", "Sorry. You don't have the right to mark the message read.");
            $this->redirectAction('message', 'view', 'all');
            return;
        }
        $message->markRead($msgId);
        $this->redirectAction('message', 'view', 'read');
    }


    /**
     * View messages
     * @access authenticated user
     * @param string $msgType
     */
    public function actionView($msgType = 'all')
    {
        $messages = new Message();
        $userId = Rays::app()->getLoginUser()->id;
        if ($msgType == 'all') {
            $messages = $messages->getUserMsgs($userId);
        } else if ($msgType == 'read') {
            $messages = $messages->getReadMsgs($userId);
        } else if ($msgType == 'unread') {
            $messages = $messages->getUnReadMsgs($userId);
        } else if ($msgType == 'send') {
            $messages = $messages->getUserSentMsgs($userId);
        } else {
            Rays::app()->page404();
            return;
        }
        $this->render('view', array('msgs' => $messages, 'type' => $msgType), false);
    }

}