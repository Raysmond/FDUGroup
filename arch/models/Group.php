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
}
