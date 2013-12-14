<?php
/**
 * MessageController class file.
 *
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

    // to be implemented
    public function actionDetail($msgId = '')
    {
        $message = Message::get($msgId);
        RAssert::not_null($message);

        $loginId = Rays::user()->id;
        if ($message->receiverId != $loginId && $message->senderId != $loginId) {
            $this->flash("error", "Sorry. You don't have the right to read the message.");
            $this->redirectAction('message', 'view', 'all');
            return;
        }

        /* TODO: Auto join */
        $message->status = Message::STATUS_READ;
        $message->save();
        $message->type = MessageType::get($message->typeId);

        $this->render('detail', array('message' => $message), false);
    }

    // to be implemented
    // permissions should be considered
    public function actionSend($type = 'private', $toUserId = null)
    {
        $types = array('system', 'user', 'private', 'group');
        RAssert::is_true(in_array($type, $types));

        $data = array('type' => $type);
        if($toUserId!=null){
            $data['toUser'] = User::get($toUserId);
        }

        if (Rays::isPost()) {
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
                    $message = Message::sendMessage($_POST['type'], $senderId, $receiver->id, $title, $msgContent, null, 1);

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


    public function actionRead($msgId=null)
    {
        $msgId = Rays::getParam("messageId",$msgId);
        $message = Message::get($msgId);
        if(Rays::isAjax()){
            if (Rays::user()->id != $message->receiverId) {
                echo "Sorry. You don't have the right to mark the message read.";
                exit;
            }
            $message->status = Message::STATUS_READ;
            $message->save();
            echo 'success';
            exit;
        }
        RAssert::not_null($message);

        if (Rays::user()->id != $message->receiverId) {
            $this->flash("error", "Sorry. You don't have the right to mark the message read.");
        }
        $message->status = Message::STATUS_READ;
        $message->save();
        $this->redirect(Rays::referrerUri());
    }


    /**
     * View messages
     * @access authenticated user
     * @param string $msgType
     */
    public function actionView($msgType = 'all')
    {
        $this->setHeaderTitle("My Messages");
        $userId = Rays::user()->id;

        $curPage = $this->getPage('page');
        $pageSize = $this->getPageSize("pagesize", 5);

        /* TODO: Maybe move these model-related things into Message model directly */
        $query = Message::find("receiverId", $userId);
        switch($msgType) {
            case "all":
                $query = $query->where("[status] != ? ", array(Message::STATUS_TRASH));
                break;
            case "read":
                $query = $query->find("status", Message::STATUS_READ);
                break;
            case "unread":
                $query = $query->find("status", Message::STATUS_UNREAD);
                break;
            case "trash":
                $query = $query->find("status", Message::STATUS_TRASH);
                break;
            default:
                $this->page404();
                return;
        }
        $count = $query->count();
        $messages = $query->join('type')->order_desc("id")->range(($curPage - 1) * $pageSize, $pageSize);
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
        $message = Message::get($msgId);
        RAssert::not_null($message);
        $user = Rays::user();
        if (($message->receiverId == $user->id) || $user->isAdmin()) {
            $message->status = Message::STATUS_TRASH;
            $message->save();
        }
        $this->redirect(Rays::referrerUri());
    }

    public function actionDelete($msgId)
    {
        $message = Message::get($msgId);
        RAssert::not_null($message);
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
