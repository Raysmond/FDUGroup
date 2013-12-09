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
                $whereSQL = "WHERE groups.{$group::$mapping['categoryId']} IN ({$categoryId},";
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
        $prefix = Rays::app()->getDBPrefix();
        $sql = "SELECT "
            . "user.{$user::$mapping['id']},"
            . "user.{$user::$mapping['name']},"
            . "user.{$user::$mapping['picture']},"
            . "topic.{$topic::$mapping['id']},"
            . "topic.{$topic::$mapping['title']},"
            . "topic.{$topic::$mapping['content']},"
            . "topic.{$topic::$mapping['createdTime']},"
            . "topic.{$topic::$mapping['commentCount']},"
            . "groups.{$group::$mapping['id']},"
            . "groups.{$group::$mapping['name']},"
            . "rating.{$ratingStats::$mapping['value']} AS plusCount "
            . "FROM {$prefix}{$topic::$table} as topic "
            . "LEFT JOIN {$prefix}{$user::$table} as user ON user.{$user::$mapping['id']}=topic.{$topic::$mapping['userId']} "
            . "LEFT JOIN {$prefix}{$group::$table} as groups ON groups.{$group::$mapping['id']}=topic.{$topic::$mapping['groupId']} "
            . "LEFT JOIN {$prefix}{$this::$table} AS category ON  category.{$this::$mapping['id']}=groups.{$group::$mapping['categoryId']} "
            . "LEFT JOIN {$prefix}{$ratingStats::$table} AS rating on rating.{$ratingStats::$mapping['entityType']}={$entityType} "
            . "AND rating.{$ratingStats::$mapping['entityId']}=topic.{$topic::$mapping['id']} "
            . "AND rating.{$ratingStats::$mapping['tag']}='plus' "
            . "AND rating.{$ratingStats::$mapping['type']}='count'"
            . $whereSQL
            . "ORDER BY topic.{$topic::$mapping['id']} DESC "
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
                $whereSQL = "WHERE groups.{$group->mapping['categoryId']} IN ({$categoryId},";
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

        $prefix = Rays::app()->getDBPrefix();
        $sql = "SELECT "
            . "COUNT(topic.{$topic::$mapping['id']}) AS totalCount "
            . "FROM {$prefix}{$topic::$table} as topic "
            . "LEFT JOIN {$prefix}{$group::$table} as groups ON groups.{$group::$mapping['id']}=topic.{$topic::$mapping['groupId']} "
            . "LEFT JOIN {$prefix}{$this::$table} AS category ON  category.{$this::$mapping['id']}=groups.{$group::$mapping['categoryId']} "
            . $whereSQL
            . "";

        $result = Data::db_query($sql);

        return $result[0]["totalCount"];
    }
}