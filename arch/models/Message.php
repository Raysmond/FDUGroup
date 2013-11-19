<?php
/**
 * Message Model class file.
 * @author: Raysmond
 */

class Message extends Data{
    public $type;
    public $sender;
    public $id,$typeId,$senderId,$receiverId,$title,$content,$sendTime,$status;

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
        parent::load($id);
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
            date_default_timezone_set(Rays::app()->getTimeZone());
            $this->sendTime = date('Y-m-d H:i:s');;
        }
        $_id = $this->insert();
        $this->load($_id);
    }

    public function markRead($msgId=''){
        if($msgId!='')
            $this->id = $msgId;
        $this->load();
        $this->status = 2;
        $this->update();

    }

    public function markUnRead($msgId=''){
        if($msgId!='')
            $this->id = $msgId;
        $this->load();
        $this->status = 1;
        $this->update();
    }

    public function getUnReadMsgs($receiverId)
    {
        if(!isset($receiverId)||$receiverId==''){
            return null;
        }
        $msgs = new Message();
        $msgs->status = 1;
        $msgs->receiverId = $receiverId;
        return $msgs->find(0,0,array('key'=>'msg_id','order'=>'desc'));
    }

    public function getReadMsgs($receiverId)
    {
        if(!isset($receiverId)||$receiverId==''){
            return null;
        }
        $msgs = new Message();
        $msgs->status = 2;
        $msgs->receiverId = $receiverId;
        return $msgs->find(0,0,array('key'=>'msg_id','order'=>'desc'));
    }

    public function getUserMsgs($receiverId)
    {
        if(!isset($receiverId)||$receiverId==''){
            return null;
        }
        $msgs = new Message();
        $msgs->receiverId = $receiverId;
        return $msgs->find(0,0,array('key'=>'msg_status,msg_id','order'=>'desc'));
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

    public function countUnreadMsgs($receiverId)
    {
        return count($this->getUnReadMsgs($receiverId));
    }
}