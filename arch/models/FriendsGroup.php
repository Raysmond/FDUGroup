<?php
/**
 * Class FriendsGroup
 * @author: Raysmond
 */
class FriendsGroup extends Data{
    public $groupId1,$groupId2;

    public function __construct(){
        $option = array(
            "key1"=>"groupId1",
            "key2"=>"groupId2",
            "table"=>"group_has_group",
            "columns"=>array(
                "groupId1"=>"group_id1",
                "groupId2"=>"group_id2"
            )
        );
        parent::init($option);
    }
}