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
        $message = Message::get($msgId);

        $loginId = Rays::app()->getLoginUser()->id;
        if ($message->receiverId != $loginId && $message->senderId != $loginId) {
            $this->flash("error", "Sorry. You don't have the right to read the message.");
            $this->redirectAction('message', 'view', 'all');
            return;
        }

        /* TODO: Auto join */
        $message->type = MessageType::get($message->typeId);

        $this->render('detail', array('message' => $message), false);
    }

    // to be implemented
    // permissions should be considered
    public function actionSend($type=null)
    {
        $types = array('system', 'user', 'private', 'group');
        if(!$type){
            $type = 'private';
        }
        if (!in_array($type, $types)) {
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
                    $senderId = 0;
                    if (isset($_POST['sender'])) { //mainly for group and system message
                        $senderId = $_POST['sender'];
                    } else {
                        $senderId = Rays::app()->getLoginUser()->id;
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
        $message = Message::get($msgId);
        if (Rays::app()->getLoginUser()->id != $message->receiverId) {
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
        $userId = Rays::app()->getLoginUser()->id;

        $curPage = $this->getHttpRequest()->getQuery('page',1);
        $pageSize = (isset($_GET['pagesize'])&&is_numeric($_GET['pagesize']))?$_GET['pagesize'] : 5;

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
                break;
            case "trash":
                $query = $query->find("status", Message::$STATUS_TRASH);
                break;
            default:
                Rays::app()->page404();
                return;
        }
        $count = $query->count();
        $messages = $query->order_desc("id")->range(($curPage - 1) * $pageSize, $pageSize);
        $url = RHtmlHelper::siteUrl('message/view/'.$msgType);
        $pager = new RPagerHelper('page',$count,$pageSize,$url,$curPage);
        $data =  array(
            'msgs' => $messages,
            'type' => $msgType,
            'pager' => $pager->showPager(),
            'count'=>$count,
            );

        $this->render('view',$data, false);
    }

    public function actionTrash($msgId)
    {
        if (isset($msgId) && is_numeric($msgId)) {
            $message = Message::find(array("id", $msgId, "receiverId", Rays::app()->getLoginUser()->id))->first();
            $message->status = Message::$STATUS_TRASH;
            $message->save();
        }
        $this->redirect($this->getHttpRequest()->getUrlReferrer());
    }

    public function actionDelete($msgId)
    {
        if (isset($msgId) && is_numeric($msgId)) {
            $user = Rays::app()->getLoginUser();
            if ($user->isAdmin()) {
                Message::find("id", $msgId)->delete();
            }
            else {
                Message::find(array("id", $msgId, "receiverId", $user->id))->delete();
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