<?php
/**
 * Message Model class file.

 * @author: songrenchu, Raysmond
 */

class Censor extends RModel
{
    public $type, $sender, $related;
    public $id, $typeId, $firstId, $secondId, $content, $sendTime, $status;

    const UNPROCESS = 1;
    const PASS = 2;
    const DENY = 3;

    public static $table = "censor";
    public static $primary_key = "id";
    public static $mapping = array(
        'id' => 'csr_id',
        'typeId' => 'csr_type_id',
        'firstId' => 'csr_first_id',
        'secondId' => 'csr_second_id',
        'content' => 'csr_content',
        'sendTime' => 'csr_send_time',
        'status' => 'csr_status');

    public static $relation = array(
        'type' => array('typeId', "CensorType", "typeId")
    );

    public static function load($id = null)
    {
        $result = Censor::find("id", $id)->join("type")->first();
        if ($result !== null) {
            $result->sender = User::get($result->firstId);
            switch ($result->type->typeName) {
                case 'add_friend':
                    $result->related = User::get($result->secondId);
                    break;
                case 'apply_vip':
                    $result->related = null;
                    break;
                case 'join_group':
                    $result->related = Group::get($result->secondId);
                    break;
                case 'post_ads':
                    /* TODO */
                    break;
            }
        }
        return $result;
    }

    private static $_type_id_mapping = array();

    public function getTypeId($typeName)
    {
        if (!isset(self::$_type_id_mapping[$typeName])) {
            self::$_type_id_mapping[$typeName] = CensorType::find("typeName", $typeName)->first()->typeId;
        }
        $this->typeId = self::$_type_id_mapping[$typeName];
        return self::$_type_id_mapping[$typeName];
    }

    public function postApplication($typeName, $firstId, $secondId = null, $content = null, $sendTime = null, $status = self::UNPROCESS)
    {
        $this->getTypeId($typeName);

        $this->firstId = $firstId;
        $this->secondId = $secondId;
        $this->content = $content;
        $this->sendTime = $sendTime;
        $this->status = $status;
        if (!isset($this->sendTime) || $this->sendTime == '') {
            $this->sendTime = date('Y-m-d H:i:s');;
        }
        $this->save();
    }

    public function pass(){
        if(isset($this->id)){
            $this->status = self::PASS;
            $this->save();
        }
    }

    public function fail(){
        if(isset($this->id)){
            $this->status = self::DENY;
            $this->save();
        }
    }

    public function addFriendApplication($userFrom, $userTo)
    {
        $this->postApplication('add_friend', $userFrom, $userTo);
        return $this;
    }

    public function addFriendExist($userFrom, $userTo)
    {
        return Censor::find(['typeId', $this->getTypeId('add_friend'), 'firstId', $userFrom, "secondId", $userTo, "status", self::UNPROCESS])->first();
    }

    public function joinGroupApplication($userId, $groupId)
    {
        $this->postApplication('join_group', $userId, $groupId);
        return $this;
    }

    public function joinGroupExist($userId, $groupId)
    {
        return Censor::find(['typeId', $this->getTypeId('join_group'), 'firstId', $userId, "secondId", $groupId, "status", self::UNPROCESS])->first();
    }

    public function applyVIPApplication($userId, $content)
    { //apply for VIP
        $this->postApplication('apply_vip', $userId, null, $content);
        return $this;
    }

    public function applyVIPExist($userId)
    {
        return Censor::find(['typeId', $this->getTypeId('apply_vip'), 'firstId', $userId, "status", self::UNPROCESS])->first();
    }

    public function joinGroupInvitationApplication($userId, $groupId)
    {
        $this->postApplication('join_group_invite', $userId, $groupId);
        return $this;
    }

    public function joinGroupInvitationExist($userId, $groupId)
    {
        return Censor::find(['typeId', $this->getTypeId('join_group_invite'), 'firstId', $userId, "secondId", $groupId, "status", self::UNPROCESS])->first();
    }
}
