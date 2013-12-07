<?php
/**
 * Message Model class file.
 * @author: Raysmond
 */

class Message extends Data{
    public $type;
    public $sender;
    public $id,$typeId,$senderId,$receiverId,$title,$content,$sendTime,$status;

    public static $STATUS_UNREAD = 1;
    public static $STATUS_READ = 2;
    public static $STATUS_TRASH = 3;

    public function __construct()
    {
        $options = array(
            'key'=>'id',
            'table'=>'messages',
            'columns'=>array(
                'id'=>'msg_id',
                'typeId'=>'msg_type_id',
                'senderId'=>'msg_sender_id',
                'receiverId'=>'msg_receiver_id',
                'title'=>'msg_title',
                'content'=>'msg_content',
                'sendTime'=>'msg_send_time',
                'status'=>'msg_status',
            )
        );
        parent::init($options);
    }

    public function load($id=null)
    {
        $result = parent::load($id);
        if($result==null) return null;
        $this->type = new MessageType();
        $this->type->typeId = $this->typeId;
        $this->type->load();
        if($this->type->typeName!='system'){
            if($this->type->typeName=='user'){
                $this->sender = new User();
                $this->sender->id = $this->senderId;
            }
            else if($this->type->typeName=='group'){
                $this->sender = new Group();
                $this->sender->id = $this->senderId;
            }
        }
        else{
            $this->sender = 'system';
        }
        return $this;
    }

    public function sendMsg($typeName,$senderId,$receiverId,$title,$content,$sendTime=null,$status=1)
    {
        $this->typeId = new MessageType();
        $this->typeId->typeName = $typeName;
        $this->typeId = $this->typeId->find()[0]->typeId;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->title = $title;
        $this->content = $content;
        $this->sendTime = $sendTime;
        $this->status = $status;
        if(!isset($this->sendTime)||$this->sendTime==''){
            $this->sendTime = date('Y-m-d H:i:s');;
        }
        $_id = $this->insert();
        $this->load($_id);
    }

    public static function sendMessage($typeName,$senderId,$receiverId,$title,$content,$sendTime=null,$status=1)
    {
        $message = new Message();
        $message->sendMsg($typeName,$senderId,$receiverId,$title,$content,$sendTime,$status);
        return $message;
    }

    public function markRead($msgId=''){
        $this->markStatus($msgId,self::$STATUS_READ);

    }

    public function markUnRead($msgId=''){
        $this->markStatus($msgId,self::$STATUS_UNREAD);
    }

    public function markTrash($msgId=''){
        $this->markStatus($msgId,self::$STATUS_TRASH);
    }

    public function markStatus($msgId, $status)
    {
        if (isset($msgId) && is_numeric($msgId)) {
            $this->id = $msgId;
            $result = $this->load();
            if ($result != null) {
                $this->status = $status;
                $this->update();
            }
        }
    }

    public function getUnReadMsgs($receiverId,$page=0,$pageSize=0)
    {
        if(!isset($receiverId)||$receiverId==''){
            return null;
        }
        $msgs = new Message();
        $msgs->status = self::$STATUS_UNREAD;
        $msgs->receiverId = $receiverId;
        return $msgs->find($page,$pageSize,array('key'=>'msg_id','order'=>'desc'));
    }

    public function getReadMsgs($receiverId,$page=0,$pageSize=0)
    {
        if(!isset($receiverId)||$receiverId==''){
            return null;
        }
        $msgs = new Message();
        $msgs->status = self::$STATUS_READ;
        $msgs->receiverId = $receiverId;
        return $msgs->find($page,$pageSize,array('key'=>'msg_id','order'=>'desc'));
    }

    public function getUserMsgs($receiverId,$page=0,$pageSize=0)
    {
        if(!isset($receiverId)||$receiverId==''){
            return null;
        }
        $msgs = new Message();
        $msgs->receiverId = $receiverId;
        return $msgs->find($page,$pageSize,array('key'=>'msg_status,msg_id','order'=>'desc'),array(),
            array('status'=>array(self::$STATUS_READ,self::$STATUS_UNREAD)));
    }

    public function getUserSentMsgs($userId)
    {
        if(!isset($userId)||$userId==''){
            return null;
        }
        $msgs = new Message();

        $msgs->senderId = $userId;
        return $msgs->find(0,0,array('key'=>'msg_id','order'=>'desc'));
    }

    public function getTrashMsgs($userId){
        if(!isset($userId)||$userId==''){
            return null;
        }
        $msg = new Message();
        $msg->receiverId = $userId;
        $msg->status = self::$STATUS_TRASH;
        return $msg->find(0,0,array('key'=>'msg_id','order'=>'desc'));
    }

    public function countUnreadMsgs($receiverId)
    {
        return count($this->getUnReadMsgs($receiverId));
    }

}