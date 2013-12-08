<?php
/**
 * Data model for indivudal messages
 * @author: Raysmond, Xiangyan Sun
 */

class Message extends RModel {
    public $type;
    public $sender;
    public $id, $typeId, $senderId, $receiverId, $title, $content, $sendTime, $status;

    public static $STATUS_UNREAD = 1;
    public static $STATUS_READ = 2;
    public static $STATUS_TRASH = 3;

    public static $table = "messages";
    public static $primary_key = "id";
    public static $mapping = array(
        'id'=>'msg_id',
        'typeId'=>'msg_type_id',
        'senderId'=>'msg_sender_id',
        'receiverId'=>'msg_receiver_id',
        'title'=>'msg_title',
        'content'=>'msg_content',
        'sendTime'=>'msg_send_time',
        'status'=>'msg_status',
    );

    /*public function load($id=null)
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
    }*/

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

    public static function countUnreadMsgs($receiverId)
    {
        return Message::find(array("receiverId", $receiverId, "status", Message::$STATUS_UNREAD))->count();
    }
}