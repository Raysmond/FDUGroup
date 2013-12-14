<?php
/**
 * Data model for indivudal messages
 * @author: Raysmond, Xiangyan Sun
 */

class Message extends RModel {
    public $type;
    public $sender;
    public $id, $typeId, $senderId, $receiverId, $title, $content, $sendTime, $status;

    const STATUS_UNREAD = 1;
    const STATUS_READ = 2;
    const STATUS_TRASH = 3;

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

    public static $relation = array(
        'type' => array("MessageType", "[typeId] = [MessageType.id]")
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

    public static function sendMessage($typeName,$senderId,$receiverId,$title,$content,$sendTime=null,$status=1)
    {
        $message = new Message();
        $message->typeId = MessageType::find("name", $typeName)->first()->id;
        $message->senderId = $senderId;
        $message->receiverId = $receiverId;
        $message->title = $title;
        $message->content = $content;
        $message->sendTime = $sendTime;
        $message->status = $status;
        if (!isset($message->sendTime) || $message->sendTime == '') {
            $message->sendTime = date('Y-m-d H:i:s');;
        }
        $message->save();
        return $message;
    }
}