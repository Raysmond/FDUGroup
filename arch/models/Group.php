<?php
/**
 * Class Group
 * @author: Raysmond
 */

class Group extends Data
{
    public $groupCreator;
    public $category;
    public $id, $creator, $categoryId, $name, $memberCount, $createdTime, $intro;

    public function __construct()
    {
        $option = array(
            "key" => "id",
            "table" => "groups",
            "columns" => array(
                "id" => "gro_id",
                "creator" => "gro_creator",
                "categoryId" => "cat_id",
                "name" => "gro_name",
                "memberCount" => "gro_member_count",
                "createdTime" => "gro_created_time",
                "intro" => "gro_intro"

            )
        );
        parent::init($option);
    }

    public function load($id = null)
    {
        parent::load($id);
        $this->groupCreator = new User();
        $this->groupCreator->id = $this->creator;
        $this->groupUsers = array();
        $this->category = new Category();
        $this->category->id = $this->categoryId;
    }

    public function groupUsers(){
        $groupusers = new GroupUser();
        $groupusers->groupId = $this->id;
        return $groupusers->find();
    }

    public function setDefaults(){
        if(!isset($this->memberCount))
            $this->memberCount = 1;
        date_default_timezone_set(Rays::app()->getTimeZone());
        $this->createdTime = date('Y-m-d H:i:s');
    }

    public function buildGroup($groupName,$categoryId,$introduction,$creatorId){
        $this->setDefaults();
        $this->name = $groupName;
        $this->categoryId = $categoryId;
        $this->intro = $introduction;
        $this->creator = $creatorId;
        $this->insert();
        $group = $this->find()[0];

        $groupUser = new GroupUser();
        $groupUser->groupId = $group->id;
        $groupUser->userId = $group->creator;
        date_default_timezone_set(Rays::app()->getTimeZone());
        $groupUser->joinTime = date('Y-m-d H:i:s');
        $groupUser->status = 1;
        $groupUser->insert();

    }
}
