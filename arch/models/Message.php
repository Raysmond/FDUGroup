<?php
/**
 * Message Model class file.
 * @author: Raysmond
 */

class Message extends Data{
    public $type;
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
    }

    public function sendMsg($typeId,$senderId,$receiverId,$title,$content,$sendTime,$status=0)
    {
        $this->typeId = $typeId;
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
        $this->status = 1;
        $this->update();
    }

    public function markUnRead($msgId=''){
        if($msgId!='')
            $this->id = $msgId;
        $this->load();
        $this->status = 0;
        $this->update();
    }

    public function getUnReadMsgs($receiverId)
    {
        if(!isset($receiverId)||$receiverId==''){
            return null;
        }
        $msgs = new Message();
        $msgs->status = 0;
        $msgs->receiverId = $receiverId;
        return $msgs->find(0,0,array('key'=>'msg_id','order'=>'desc'));
    }

    public function getReadMsgs($receiverId)
    {
        if(!isset($receiverId)||$receiverId==''){
            return null;
        }
        $msgs = new Message();
        $msgs->status = 1;
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
        return $msgs->find(0,0,array('key'=>'msg_id','order'=>'desc'));
    }

}