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
        return true;
    }

    // to be implemented
    public function actionDetail($msgId = '')
    {
        // message filtered in beforeAction() method
        $message = $this->filteredMessage();

        $loginId = Rays::user()->id;
        if ($message->receiverId != $loginId && $message->senderId != $loginId) {
            $this->flash("error", "Sorry. You don't have the right to read the message.");
            $this->redirectAction('message', 'view', 'all');
            return;
        }

        $message->markRead($msgId);
        $message->type->load();

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
                        $senderId = Rays::user()->id;
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
        // message filtered in beforeAction() method
        $message = $this->filteredMessage();

        $referrer = Rays::referrerUri();
        if (Rays::user()->id != $message->receiverId) {
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
        $this->setHeaderTitle("My Messages");
        $messages = new Message();
        $userId = Rays::user()->id;

        $curPage = $this->getPage('page');
        $pageSize = $this->getPageSize("pagesize", 5);

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
                break;
            //case "send":
            //    $messages = $messages->getUserSentMsgs($userId);
            //    break;
            case "trash":
                $count->status = Message::$STATUS_TRASH;
                $count = $count->count();
                $messages = $messages->getTrashMsgs($userId);
                break;
            default:
                $this->page404();
                return;
        }
        if ($messages == null) $messages = array();
        $data = array(
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
        // message filtered in beforeAction() method
        $message = $this->filteredMessage();
        if ($message->receiverId == Rays::user()->id) {
            $message->markTrash($msgId);
        }

        $this->redirect(Rays::referrerUri());
    }

    public function actionDelete($msgId)
    {
        // message filtered in beforeAction() method
        $message = $this->filteredMessage();

        $user = Rays::user();
        if (($message->receiverId == $user->id || $user->isAdmin())) {
            $message->delete();
        }
        $this->redirect(Rays::referrerUri());
    }

    public function actionSendAdmin()
    {
        $this->layout = 'admin';
        $this->actionSend('system');
    }
}