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
    public static $parent_key = "pid";
    public static $table = "category";
    public static $mapping = array(
        "id" => "cat_id",
        "name" => "cat_name",
        "pid" => "cat_pid"
    );

    public function delete($assignment = array())
    {
        if (!isset($this->id) || $this->id == '')
            return;

        $group = new Group();
        $group->categoryId = $this->id;
        $groups = $group->find();
        foreach ($groups as $item) {
            $item->categoryId = self::DEFAULT_CATEGORY_ID;
            $item->save();
        }
        parent::delete($assignment);
    }

    /**
     * TODO: how to define active posts?
     *
     * @param null $categoryId
     * @param int $start
     * @param int $limit
     */
    public function getActivePosts($categoryId = null, $start = 0, $limit = 0)
    {
        $where = "";
        if ($categoryId !== null) {
            $this->id = $categoryId;
            $subs = $this->children();
            $where = Group::$mapping['categoryId']." IN ({$categoryId},";
            $total = count($subs);
            $count = 0;
            foreach ($subs as $item) {
                $where .= $item->id;
                $where .= (++$count<$total)?",":"";
            }
            $where .= ") ";
        }

        $query =  Topic::find()->join("user")->join("group")->where($where);

        $groups = ($start!=0||$limit!=0) ? $query->range($start,$limit) : $query->all();

        return $groups;
    }

    /**
     * TODO: how to define active posts?
     *
     * Now the method count all posts in a given category
     * @param null $categoryId
     * @return mixed
     */
    public function getActivePostsCount($categoryId = null)
    {
        $where = "";
        if ($categoryId !== null) {
            $this->id = $categoryId;
            $subs = $this->children();
            $where = Group::$mapping['categoryId'] . " IN ({$categoryId},";
            $total = count($subs);
            $count = 0;
            foreach ($subs as $item) {
                $where .= $item->id . ((++$count < $total) ? "," : "");
            }
            $where .= ") ";
        }

        return Topic::find()->join("group")->where($where)->count();
    }
}