<?php
/**
 * Data model for user-group relation
 * @author: Raysmond
 */

class GroupUser extends RModel
{
    public $groupId, $userId, $joinTime, $status, $comment;

    public static $primary_key = "groupId";
    public static $table = "group_has_users";
    public static $mapping = array(
        "groupId" => "gro_id",
        "userId" => "u_id",
        "joinTime" => "join_time",
        "status" => "status",
        "comment" => "join_comment"
    );

    public static function userGroups($userId, $start = 0, $limit = 0)
    {
//        $groupUser = new GroupUser();
//        $groupUser->userId = $userId;
//        $userGroups = $groupUser->find($start, $limit, ['key' => $groupUser->columns['groupId'], 'order' => 'desc']);
//        foreach($userGroups as $userGroup){
//            $group = new Group();
//            $group->id = $userGroup->groupId;
//            $group->load();
//            array_push($result,$group);
//        }

        $groupUsers = GroupUser::find("userId",$userId)->all();
        if($groupUsers==null||empty($groupUsers)){
            return array();
        }

        $groups = array();
        $ids = [];
        foreach($groupUsers as $item){
            $ids[] = $item->groupId;
            $groups[] = Group::get($item->groupId);
        }
        //$groups = Group::find()->order_desc("id")->where("id",$ids)->range($start,$limit);
        return $groups;
    }

    public static function removeUsers($groupId,$userIds=array()){
        $groupUser = new GroupUser();
        foreach($userIds as $id){
            $groupUser->delete(array('groupId'=>$groupId, 'userId'=>$id));
        }
    }

    public static function isUserInGroup($userId, $groupId){
        if (GroupUser::find(array("groupId", $groupId, "userId", $userId))->first() != null)
            return true;
        else
            return false;
    }

    public function delete($assignment = []) {
        if(is_numeric($this->groupId) && is_numeric($this->userId)){
            $sql = "DELETE FROM {$this->table} WHERE {$this->columns['groupId']}={$this->groupId} AND {$this->columns['userId']} = {$this->userId} LIMIT 1";
            Data::executeSQL($sql);
        }
    }
}

