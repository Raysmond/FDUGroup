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

    public static function getGroups($userId)
    {
        $result = array();
        $groups = GroupUser::find("userId", $userId)->all();
        foreach ($groups as $u) {
            $group = Group::get($u->groupId);
            array_push($result, $group);
        }
        return $result;
    }

    public static function isUserInGroup($userId, $groupId){
        if (GroupUser::find(array("groupId", $groupId, "userId", $userId))->first() != null)
            return true;
        return false;
    }
}

