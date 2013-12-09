<?php
class Friend extends RModel
{
    public $id, $uid, $fid;
    public $user;

    public static $primary_key = "id";
    public static $table = "friends";
    public static $mapping = array(
        "id" => "f_id",
        "uid" => "f_uid",
        "fid" => "f_fid"
    );

    public static $relation = array(
        'user'=>array('fid',"User","id")
    );

    public function getFriends($uid = '', $friendLimit = '', $excludeIds = array(), $friendStart = 0)
    {
        $query = Friend::find();
        if ($uid != '') {
            $query->find("uid", $uid);
        }
        $friendsCount = $query->count();
        $friends = $query->order_desc("id")->range($friendStart, $friendLimit);
        $result = array();
        foreach ($friends as $friend) {
            if (!in_array($friend->fid, $excludeIds)) {
                $result[] = User::get($friend->fid);
            }
        }
        return [$result, $friendsCount];
    }

    
    public function getFriendsToInvite($uid, $groupId, $start = 0, $limit = 0)
    {
        $groupUsers = GroupUser::find("groupId", $groupId)->all();
        $result = Friend::find("uid", $uid)->join("user");
        if ($groupUsers != null && !empty($groupUsers)) {
            $where = "[fid] not in(";
            $args = [];
            for ($count = count($groupUsers), $i = 0; $i < $count; $i++) {
                $where .= "?" . ($i < $count - 1 ? "," : "");
                $args[] = $groupUsers[$i]->userId;
            }
            $where .= ")";
            $result = $result->where($where, $args);
        }

        $result = ($limit != 0 || $start != 0) ? $result->range($start, $limit) : $result->all();
        return $result;
    }
}