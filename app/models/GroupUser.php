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

    public function userGroups($userId = null)
    {
        if($userId == null) return null;
        $result = array();
        $this->userId = $userId;
        $userGroups = $this->find();
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

    public function isUserInGroup($userId, $groupId){
        $allUsers = $this->groupUsers($groupId);
        foreach($allUsers as $user){
            if($user->userId == $userId) return true;
        }
        return false;
    }
}

