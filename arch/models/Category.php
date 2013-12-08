<?php
/**
 * Category data model
 * @author: Raysmond, Xiangyan Sun
 */

class Category extends Tree
{
    public $id, $pid, $name;

    const DEFAULT_CATEGORY_ID = 48;

    public static $primary_key = "id";
    public static $table = "category";
    public static $mapping = array(
        "id" => "cat_id",
        "name" => "cat_name",
        "pid" => "cat_pid"
    );

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