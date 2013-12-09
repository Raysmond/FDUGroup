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

    public function getFriendsToInvite($uid,$groupId, $limit=0){
        $result = array();
        $result = Friend::find("uid",$uid)->join("user")->all();
        return $result;
    }
}