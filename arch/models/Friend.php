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

    public function getFriends($uid = '', $friendLimit = '')
    {
        if ($uid != '')
            $this->uid = $uid;
        $friends = $this->find();
        $result = array();
        foreach ($friends as $friend) {
            $user = new User();
            $user->id = $friend->fid;
            $user->load();
            array_push($result, $user);
        }
        return $result;
    }
}