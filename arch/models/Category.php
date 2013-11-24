<?php
/**
 * Class Category
 * @author: Raysmond
 */

class Category extends Tree
{
    public $id, $pid, $name;

    const DEFAULT_CATEGORY_ID = 48;

    public function __construct()
    {
        $option = array(
            "key" => "id",
            "pkey" => "pid",
            "table" => "category",
            "columns" => array(
                "id" => "cat_id",
                "name" => "cat_name",
                "pid" => "cat_pid"
            )
        );

        parent::init($option);
    }

    public function delete($assignment=array()){
        if(!isset($this->id)||$this->id=='')
            return;

        $group = new Group();
        $group->categoryId = $this->id;
        $groups = $group->find();
        foreach($groups as $item){
            $item->categoryId = self::DEFAULT_CATEGORY_ID;
            $item->update();
        }
        parent::delete($assignment);
    }
}