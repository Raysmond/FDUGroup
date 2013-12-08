<?php
class Friend extends RModel
{
    public $id, $uid, $fid;

    public static $primary_key = "id";
    public static $table = "friends";
    public static $mapping = array(
        "id" => "f_id",
        "uid" => "f_uid",
        "fid" => "f_fid"
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
                $user = new User();
                $user->id = $friend->fid;
                $user->load();
                $result[] = $user;
            }
        }
        return [$result, $friendsCount];
    }

    public function getFriendsToInvite($uid,$groupId, $limit=0){
        $user = new User();
        $group = new Group();
        $groupUser = new GroupUser();
        $sql = "SELECT "
            ."user2.{$user->columns['id']} AS friend_id "
            .",user2.{$user->columns['name']} AS friend_name "
            .",user2.{$user->columns['picture']} AS friend_picture "
            ."FROM {$this->table} AS friends "
            ."JOIN {$user->table} AS user2 ON user2.{$user->columns['id']}={$this->columns['fid']} "
            ."WHERE {$this->columns['uid']}={$uid} "
            ."AND {$this->columns['fid']} NOT IN "
            ."(SELECT group_users.{$groupUser->columns['userId']} AS f_fid "
            ."FROM {$groupUser->table} AS group_users WHERE group_users.{$groupUser->columns['groupId']}={$groupId}) "
            .($limit!=0?"LIMIT ".$limit:"")
            ;
        $result = Data::db_query($sql);
        return $result;
    }
}