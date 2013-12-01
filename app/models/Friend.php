<?php
class Friend extends Data {
    public $id, $uid, $fid;

    public function __construct() {
        $option = array(
            "key" => "uid",
            "key2" => "fid",
            "table" => "friends",
            "columns" => array (
                "id" => "f_id",
                "uid" => "f_uid",
                "fid" => "f_fid"
            )
        );
        parent::init($option);
    }

    public function getFriends($uid = '', $friendLimit = '', $exceptFriendIds=array(), $friendStart = 0)
    {
        if ($uid != '')
            $this->uid = $uid;
        $friends = $this->find($friendStart, $friendLimit,array('key'=>$this->columns['id'],'value'=>'desc'));
        $friNumber = $this->count();
        $result = array();
        foreach ($friends as $friend) {
            if(!in_array($friend->fid,$exceptFriendIds)){
                $user = new User();
                $user->id = $friend->fid;
                $user->load();
                array_push($result, $user);
            }
        }
        return [$result, $friNumber];
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