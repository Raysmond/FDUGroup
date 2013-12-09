<?php
/**
 * MessageController class file.
 * @author: Raysmond
 */

class MessageController extends BaseController
{
    public $layout = 'user';
    public $defaultAction = 'index';
    public $access = array(
        Role::AUTHENTICATED => array('detail', 'send', 'read', 'view', 'delete', 'trash'),
        Role::ADMINISTRATOR => array('sendAdmin'),
    );

    private $_message = null;

    public function filteredMessage(){
        return isset($this->_message)?$this->_message : null;
    }

    public function beforeAction($action)
    {
        $params = $this->getActionParams();
        $result = true;
        switch ($action) {
            case "detail":
            case "delete":
            case "trash":
            case "read":
                $msg = new Message();
                $result = false;
                if (isset($params) && isset($params[0]) && is_numeric($params[0]) && $msg->load($params[0]) !== null) {
                    $result = true;
                    $this->_message = $msg;
                }
                break;
        }
        if (!$result) {
            $this->page404();
            return false;
        }
<<<<<<< HEAD:arch/controllers/MessageController.php
        $message = Message::get($msgId);
=======
        return true;
    }

    // to be implemented
    public function actionDetail($msgId = '')
    {
        // message filtered in beforeAction() method
        $message = $this->filteredMessage();
>>>>>>> master:app/controllers/MessageController.php

        $loginId = Rays::user()->id;
        if ($message->receiverId != $loginId && $message->senderId != $loginId) {
            $this->flash("error", "Sorry. You don't have the right to read the message.");
            $this->redirectAction('message', 'view', 'all');
            return;
        }

<<<<<<< HEAD:arch/controllers/MessageController.php
        /* TODO: Auto join */
        $message->type = MessageType::get($message->typeId);
=======
        $message->markRead($msgId);
        $message->type->load();
>>>>>>> master:app/controllers/MessageController.php

        $this->render('detail', array('message' => $message), false);
    }

    // to be implemented
    // permissions should be considered
    public function actionSend($type = null)
    {
        $types = array('system', 'user', 'private', 'group');
        if (!$type) {
            $type = 'private';
        }
        if (!in_array($type, $types)) {
            $this->page404();
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
                $receiver = User::find("name", $_POST['receiver'])->first();
                if ($receiver == null) {
                    $this->flash("error", "No such user.");
                } else {
                    $senderId = 0;
                    if (isset($_POST['sender'])) { //mainly for group and system message
                        $senderId = $_POST['sender'];
                    } else {
                        $senderId = Rays::user()->id;
                    }

                    $title = isset($_POST['title']) ? trim($_POST['title']) : "";
                    $msgContent = RHtmlHelper::encode($_POST['msg-content']);
                    $message = Message::sendMsg($_POST['type'], $senderId, $receiver->id, $title, $msgContent, null, 1);

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
<<<<<<< HEAD:arch/controllers/MessageController.php
        $message = Message::get($msgId);
        if (Rays::app()->getLoginUser()->id != $message->receiverId) {
=======
        // message filtered in beforeAction() method
        $message = $this->filteredMessage();

        $referrer = Rays::referrerUri();
        if (Rays::user()->id != $message->receiverId) {
>>>>>>> master:app/controllers/MessageController.php
            $this->flash("error", "Sorry. You don't have the right to mark the message read.");
        }
        $message->status = Message::$STATUS_READ;
        $message->save();
        $this->redirect($this->getHttpRequest()->getUrlReferrer());
    }


    /**
     * View messages
     * @access authenticated user
     * @param string $msgType
     */
    public function actionView($msgType = 'all')
    {
        $this->setHeaderTitle("My Messages");
<<<<<<< HEAD:arch/controllers/MessageController.php
        $userId = Rays::app()->getLoginUser()->id;
=======
        $messages = new Message();
        $userId = Rays::user()->id;
>>>>>>> master:app/controllers/MessageController.php

        $curPage = $this->getPage('page');
        $pageSize = $this->getPageSize("pagesize", 5);

<<<<<<< HEAD:arch/controllers/MessageController.php
        /* TODO: Maybe move these model-related things into Message model directly */
        $query = Message::find("receiverId", $userId);
        switch($msgType) {
            case "all":
                $query = $query->where(Message::$mapping['status']." != ? ", array(Message::$STATUS_TRASH));
                break;
            case "read":
                $query = $query->find("status", Message::$STATUS_READ);
                break;
            case "unread":
                $query = $query->find("status", Message::$STATUS_UNREAD);
=======
        $count = new Message();
        $count->receiverId = $userId;
        switch ($msgType) {
            case "all":
                $allCount = $count->count();
                $count->status = Message::$STATUS_TRASH;
                $trashCount = $count->count();
                $count = $allCount - $trashCount;
                $messages = $messages->getUserMsgs($userId, ($curPage - 1) * $pageSize, $pageSize);
                break;
            case "read":
                $count->status = Message::$STATUS_READ;
                $count = $count->count();
                $messages = $messages->getReadMsgs($userId, ($curPage - 1) * $pageSize, $pageSize);
                break;
            case "unread":
                $count->status = Message::$STATUS_UNREAD;
                $count = $count->count();
                $messages = $messages->getUnReadMsgs($userId, ($curPage - 1) * $pageSize, $pageSize);
>>>>>>> master:app/controllers/MessageController.php
                break;
            case "trash":
                $query = $query->find("status", Message::$STATUS_TRASH);
                break;
            default:
                $this->page404();
                return;
        }
<<<<<<< HEAD:arch/controllers/MessageController.php
        $count = $query->count();
        $messages = $query->order_desc("id")->range(($curPage - 1) * $pageSize, $pageSize);
        $url = RHtmlHelper::siteUrl('message/view/'.$msgType);
        $pager = new RPagerHelper('page',$count,$pageSize,$url,$curPage);
        $data =  array(
=======
        if ($messages == null) $messages = array();
        $data = array(
>>>>>>> master:app/controllers/MessageController.php
            'msgs' => $messages,
            'type' => $msgType,
            'count' => $count,
        );

        if ($count > $pageSize) {
            $url = RHtmlHelper::siteUrl('message/view/' . $msgType);
            $pager = new RPagerHelper('page', $count, $pageSize, $url, $curPage);
            $data['pager'] = $pager->showPager();
        }

        $this->render('view', $data, false);
    }

    public function actionTrash($msgId)
    {
<<<<<<< HEAD:arch/controllers/MessageController.php
        if (isset($msgId) && is_numeric($msgId)) {
            $message = Message::find(array("id", $msgId, "receiverId", Rays::app()->getLoginUser()->id))->first();
            $message->status = Message::$STATUS_TRASH;
            $message->save();
=======
        // message filtered in beforeAction() method
        $message = $this->filteredMessage();
        if ($message->receiverId == Rays::user()->id) {
            $message->markTrash($msgId);
>>>>>>> master:app/controllers/MessageController.php
        }

        $this->redirect(Rays::referrerUri());
    }

    public function actionDelete($msgId)
    {
<<<<<<< HEAD:arch/controllers/MessageController.php
        if (isset($msgId) && is_numeric($msgId)) {
            $user = Rays::app()->getLoginUser();
            if ($user->isAdmin()) {
                Message::find("id", $msgId)->delete();
            }
            else {
                Message::find(array("id", $msgId, "receiverId", $user->id))->delete();
            }
=======
        // message filtered in beforeAction() method
        $message = $this->filteredMessage();

        $user = Rays::user();
        if (($message->receiverId == $user->id || $user->isAdmin())) {
            $message->delete();
>>>>>>> master:app/controllers/MessageController.php
        }
        $this->redirect(Rays::referrerUri());
    }

    public function actionSendAdmin()
    {
        $this->layout = 'admin';
        $this->actionSend('system');
    }
}