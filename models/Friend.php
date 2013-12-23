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
        /* TODO: There should be two relations and the current name needs to be fixed */
        /*       Plus, work needs to be done for RModel to support joining multiple same tables */
        'user' => array("User", "[fid] = [User.id]")
    );

    public static function isFriend($uid1,$uid2)
    {
        return ($uid1 != $uid2 && Friend::find(array("uid", $uid1, "fid", $uid2))->first() != null);
    }

    public function getFriends($uid = '', $friendLimit = '', $excludeIds = array(), $friendStart = 0)
    {
        $query = Friend::find();
        if ($uid != '') {
            $query->find("uid", $uid);
        }
        $friendsCount = $query->count();
        $friends = $query->order_desc("id")->range($friendStart, $friendLimit);
        $result = array();
        $friendsQuery = User::find()->order_desc("id");
        $arg = [];
        if(!empty($friends)){
            $where = "[id] IN (";
            foreach ($friends as $friend) {
                if (!in_array($friend->fid, $excludeIds)) {
                    $where.="?,";
                    $arg[] = $friend->fid;
                }
            }
            $where = substr($where,0,strlen($where)-1);
            $where.=')';
            $friendsQuery = $friendsQuery->where($where,$arg);
        }
        $result = $friendsQuery->all();
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
            unset($groupUsers);
            $where .= ")";
            $result = $result->where($where, $args);
        }

        return ($limit != 0 || $start != 0) ? $result->range($start, $limit) : $result->all();
    }
}