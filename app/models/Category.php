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

    public function delete($assignment = array())
    {
        if (!isset($this->id) || $this->id == '')
            return;

        $group = new Group();
        $group->categoryId = $this->id;
        $groups = $group->find();
        foreach ($groups as $item) {
            $item->categoryId = self::DEFAULT_CATEGORY_ID;
            $item->update();
        }
        parent::delete($assignment);
    }

    public function getActivePosts($categoryId = null, $start = 0, $limit = 0)
    {
        $topic = new Topic();
        $group = new Group();
        $user = new User();


        $limitSQL = "";
        if ($start != 0 || $limit != 0) {
            $limitSQL .= " LIMIT {$start} , " . $limit;
        }

        $whereSQL = "";
        if ($categoryId !== null) {
            $this->id = $categoryId;
            if ($this->load() !== null) {
                $subs = $this->children();
                $whereSQL = "WHERE groups.{$group->columns['categoryId']} IN ({$categoryId},";
                $total = count($subs);
                $count = 0;
                foreach ($subs as $item) {
                    $whereSQL .= $item->id;
                    if (++$count < $total)
                        $whereSQL .= ",";
                }
                $whereSQL .= ") ";
            }
        }
        $ratingStats = new RatingStatistic();
        $entityType = Topic::$entityType;

        $sql = "SELECT "
            . "user.{$user->columns['id']},"
            . "user.{$user->columns['name']},"
            . "user.{$user->columns['picture']},"
            . "topic.{$topic->columns['id']},"
            . "topic.{$topic->columns['title']},"
            . "topic.{$topic->columns['content']},"
            . "topic.{$topic->columns['createdTime']},"
            . "topic.{$topic->columns['commentCount']},"
            . "groups.{$group->columns['id']},"
            . "groups.{$group->columns['name']},"
            . "rating.{$ratingStats->columns['value']} AS plusCount "
            . "FROM {$topic->table} as topic "
            . "LEFT JOIN {$user->table} as user ON user.{$user->columns['id']}=topic.{$topic->columns['userId']} "
            . "LEFT JOIN {$group->table} as groups ON groups.{$group->columns['id']}=topic.{$topic->columns['groupId']} "
            . "LEFT JOIN {$this->table} AS category ON  category.{$this->columns['id']}=groups.{$group->columns['categoryId']} "
            . "LEFT JOIN {$ratingStats->table} AS rating on rating.{$ratingStats->columns['entityType']}={$entityType} "
            . "AND rating.{$ratingStats->columns['entityId']}=topic.{$topic->columns['id']} "
            . "AND rating.{$ratingStats->columns['tag']}='plus' "
            . "AND rating.{$ratingStats->columns['type']}='count'"
            . $whereSQL
            . "ORDER BY topic.{$topic->columns['id']} DESC "
            . $limitSQL
            . "";

        return Data::db_query($sql);
    }

    public function getActivePostsCount($categoryId = null)
    {
        $topic = new Topic();
        $group = new Group();

        $whereSQL = "";
        if ($categoryId !== null) {
            $this->id = $categoryId;
            if ($this->load() !== null) {
                $subs = $this->children();
                $whereSQL = "WHERE groups.{$group->columns['categoryId']} IN ({$categoryId},";
                $total = count($subs);
                $count = 0;
                foreach ($subs as $item) {
                    $whereSQL .= $item->id;
                    if (++$count < $total)
                        $whereSQL .= ",";
                }
                $whereSQL .= ") ";
            }
        }

        $sql = "SELECT "
            . "COUNT(topic.{$topic->columns['id']}) AS totalCount "
            . "FROM {$topic->table} as topic "
            . "LEFT JOIN {$group->table} as groups ON groups.{$group->columns['id']}=topic.{$topic->columns['groupId']} "
            . "LEFT JOIN {$this->table} AS category ON  category.{$this->columns['id']}=groups.{$group->columns['categoryId']} "
            . $whereSQL
            . "";

        $result = Data::db_query($sql);

        return $result[0]["totalCount"];
    }
}