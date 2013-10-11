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
                "comment" => "comment"
            )
        );
        parent::init($option);
    }


    public function groupUsers($groupId = null)
    {
        if ($groupId != null) {
            $this->groupId = $groupId;
        }
        return $this->find();
    }
}

