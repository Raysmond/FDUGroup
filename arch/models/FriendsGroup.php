<?php
/**
 * Class FriendsGroup
 * @author: Raysmond
 */
class FriendsGroup extends Data{
    public $groupId1,$groupId2;

    public function __construct(){
        $option = array(
            "key"=>"groupId1",
            "key2"=>"groupId2",
            "table"=>"group_has_group",
            "columns"=>array(
                "groupId1"=>"group_id1",
                "groupId2"=>"group_id2"
            )
        );
        parent::init($option);
    }

    public function getFriends($groupId='',$friendLimit='')
    {
        if($groupId!='')
            $this->groupId1 = $groupId;
        $friends = $this->find();
        $result = array();
        foreach($friends as $friend){
            $group = new Group();
            $group->id = $friend->groupId2;
            $group->load();
            array_push($result,$group);
        }
        return $result;
    }
}