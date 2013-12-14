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
        $query = Topic::find()->join("user")->join("group")->join("rating")->join("counter");
//        $query = $query->order_desc("id");
        $query = $query->order("desc","UNIX_TIMESTAMP([Topic.createdTime])/10000 + 10* IFNULL([RatingStatistic.value],0) + 10*[Topic.commentCount] + 5*[Counter.dayCount] + [Counter.totalCount]/100");
        if ($categoryId !== null) {
            $this->id = $categoryId;
            $subs = $this->children();
            $where = "[Group.categoryId] IN (?";
            $args = [$categoryId];
            for($i=0,$count = count($subs);$i<$count;$i++){
                $where.=',?';
                $args[] = $subs[$i]->id;
            }
            $where.=')';
            $query = $query->where($where,$args);
        }

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
        $query = Topic::find()->join("group");
        if ($categoryId !== null) {
            $this->id = $categoryId;
            $subs = $this->children();
            $where = "[Group.categoryId] IN (?";
            $args = [$categoryId];
            for($i=0,$count = count($subs);$i<$count;$i++){
                $where.=',?';
                $args[] = $subs[$i]->id;
            }
            $where.=')';
            $query = $query->where($where,$args);
        }
        return $query->count();
    }
}