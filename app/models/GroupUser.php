<?php
/**
 * Class GroupUser
 * @author: Raysmond
 */

class GroupUser extends Data
{
    public $users;
    public $groupId, $userId, $joinTime, $status, $comment;

    public function __construct()
    {
        $option = array(
            "key" => "groupId",
            "table" => "group_has_users",
            "columns" => array(
                "groupId" => "gro_id",
                "userId" => "u_id",
                "joinTime" => "join_time",
                "status" => "status",
                "comment" => "join_comment"
            )
        );
        parent::init($option);
    }


    public function groupUsers($groupId = null)
    {
        if ($groupId != null) {
            $this->groupId = $groupId;
        }
        else return null;
        return $this->find();
    }

    public static function userGroups($start = 0, $limit = 0, $userId = null)
    {
        if($userId == null) return null;
        $result = array();
        $groupUser = new GroupUser();
        $groupUser->userId = $userId;
        $userGroups = $groupUser->find($start, $limit, ['key' => $groupUser->columns['groupId'], 'order' => 'desc']);
        foreach($userGroups as $userGroup){
            $group = new Group();
            $group->id = $userGroup->groupId;
            $group->load();
            array_push($result,$group);
        }
        return $result;
    }

    public static function removeUsers($groupId,$userIds=array()){
        $groupUser = new GroupUser();
        foreach($userIds as $id){
            $groupUser->delete(array('groupId'=>$groupId, 'userId'=>$id));
        }
    }

    public static function isUserInGroup($userId, $groupId){
        $groupUser = new GroupUser();
        $allUsers = $groupUser->groupUsers($groupId);
        foreach($allUsers as $user){
            if($user->userId == $userId) return true;
        }
        return false;
    }

    public function delete($assignment = []) {
        if(is_numeric($this->groupId) && is_numeric($this->userId)){
            $sql = "DELETE FROM {$this->table} WHERE {$this->columns['groupId']}={$this->groupId} AND {$this->columns['userId']} = {$this->userId} LIMIT 1";
            Data::executeSQL($sql);
        }
    }
}

