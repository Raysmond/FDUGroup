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
        'type' => array("CensorType", "[typeId] = [CensorType.typeId]")
    );

    const TYPE_APPLY_VIP = "apply_vip";
    const TYPE_ADD_FRIEND = "add_friend";
    const TYPE_JOIN_GROUP = "join_group";
    const TYPE_JOIN_GROUP_INVITE = "join_group_invite";
    const TYPE_POST_ADS = "post_ads";

    private static $_type_id_mapping = array();

    public static function load($id = null)
    {
        $result = Censor::find("id", $id)->join("type")->first();
        if ($result !== null) {
            $result->sender = User::get($result->firstId);
            switch ($result->type->typeName) {
                case self::TYPE_ADD_FRIEND:
                    $result->related = User::get($result->secondId);
                    break;
                case self::TYPE_APPLY_VIP:
                    $result->related = null;
                    break;
                case self::TYPE_JOIN_GROUP:
                    $result->related = Group::get($result->secondId);
                    break;
                case self::TYPE_POST_ADS:
                    /* TODO */
                    break;
            }
        }
        return $result;
    }

    public function getTypeId($typeName)
    {
        if (!isset(self::$_type_id_mapping[$typeName])) {
            // load all types into memory since there are limited types
            $types = CensorType::find()->all();
            foreach($types as $type){
                self::$_type_id_mapping[$type->typeName] = $type->typeId;
            }
        }
        if(isset(self::$_type_id_mapping[$typeName])){
            $this->typeId = self::$_type_id_mapping[$typeName];
            return self::$_type_id_mapping[$typeName];
        }
        return null;
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
        $this->postApplication(self::TYPE_ADD_FRIEND, $userFrom, $userTo);
        return $this;
    }

    public function addFriendExist($userFrom, $userTo)
    {
        return Censor::find(['typeId', $this->getTypeId(self::TYPE_ADD_FRIEND), 'firstId', $userFrom, "secondId", $userTo, "status", self::UNPROCESS])->first();
    }

    public function joinGroupApplication($userId, $groupId)
    {
        $this->postApplication(self::TYPE_JOIN_GROUP, $userId, $groupId);
        return $this;
    }

    public function joinGroupExist($userId, $groupId)
    {
        return Censor::find(['typeId', $this->getTypeId(self::TYPE_JOIN_GROUP), 'firstId', $userId, "secondId", $groupId, "status", self::UNPROCESS])->first();
    }

    public function applyVIPApplication($userId, $content)
    { //apply for VIP
        $this->postApplication(self::TYPE_APPLY_VIP, $userId, null, $content);
        return $this;
    }

    public function applyVIPExist($userId)
    {
        return Censor::find(['typeId', $this->getTypeId(self::TYPE_APPLY_VIP), 'firstId', $userId, "status", self::UNPROCESS])->first();
    }

    public function joinGroupInvitationApplication($userId, $groupId)
    {
        $this->postApplication(self::TYPE_JOIN_GROUP_INVITE, $userId, $groupId);
        return $this;
    }

    public function joinGroupInvitationExist($userId, $groupId)
    {
        return Censor::find(['typeId', $this->getTypeId(self::TYPE_JOIN_GROUP_INVITE), 'firstId', $userId, "secondId", $groupId, "status", self::UNPROCESS])->first();
    }
}
