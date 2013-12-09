<?php
/**
 * Topic data model
 * @author: Raysmond, Xiangyan Sun
 */
class Topic extends RModel
{
    public $group;
    public $user;
    public $comments = array();

    public $id, $groupId, $userId, $title, $createdTime, $content, $lastCommentTime, $commentCount;

    public static $entityType = 1;

    public static $primary_key = "id";
    public static $table = "topic";
    public static $mapping = array(
        "id" => "top_id",
        "groupId" => "gro_id",
        "userId" => "u_id",
        "title" => "top_title",
        "createdTime" => "top_created_time",
        "content" => "top_content",
        "lastCommentTime" => "top_last_comment_time",
        "commentCount" => "top_comment_count"
    );
    public static $relation = array(
        "group" => array("groupId", "Group", "id"),
        "user" => array("userId", "User", "id")
    );

    public function increaseCounter(){
        if(isset($this->id)&&$this->id!=''){
            $counter = new Counter();
            $counter->increaseCounter($this->id,self::$entityType);
            return $counter;
        }
    }

    public function getComments()
    {
        $comments = Comment::find(array("topicId", $this->id, "pid", 0))->all();
        $result = [];
        foreach ($comments as $c) {
            $result[] = ['root' => $c, 'reply' => $c->children()];
        }
        return $result;
    }

    public static function getUserTopics($uid, $start = 0, $limit = 0) {
        $topics = new Topic();
        $topics->userId = $uid;
        $topics = $topics->find($start, $limit, ['key' => $topics->columns['id'], 'order' => 'desc']);

        foreach($topics as $item){
            $item->group = new Group();
            $item->group->load($item->groupId);
        }

        return $topics;
    }

    public function getUserFriendsTopics($uid,$limit=0,$endTime=null){
        $friends = new Friend();
        $friends->uid = $uid;
        $friends = $friends->find();

        $topics = new Topic();
        $ids = array();
        foreach($friends as $friend){
            $ids[] = $friend->fid;
        }
        $ids[] = $uid;

        $user = new User();
        $group = new Group();
        $ratingStats = new RatingStatistic();
        $entityType = Topic::$entityType;

        $sql = "SELECT "
            ."user.".User::$mapping['id'].","
            ."user.".User::$mapping['name'].","
            ."user.".User::$mapping['picture'].","
            ."topic.".Topic::$mapping['id'].","
            ."topic.".Topic::$mapping['title'].","
            ."topic.".Topic::$mapping['content'].","
            ."topic.".Topic::$mapping['createdTime'].","
            ."topic.".Topic::$mapping['commentCount'].","
            ."groups.{$group::$mapping['id']},"
            ."groups.{$group::$mapping['name']},"
            ."rating.{$ratingStats->columns['value']} AS plusCount"
            ." FROM ".Rays::app()->getDBPrefix().Topic::$table." AS topic "
            ."LEFT JOIN ".Rays::app()->getDBPrefix().User::$table." AS user on topic.".Topic::$mapping['userId']."=user.".User::$mapping['id']." "
            ."LEFT JOIN ".Rays::app()->getDBPrefix().Group::$table." AS groups on groups.{$group::$mapping['id']}=topic.".Topic::$mapping['groupId']." "
            ."LEFT JOIN {$ratingStats->table} AS rating on rating.{$ratingStats->columns['entityType']}={$entityType} "
            ."AND rating.{$ratingStats->columns['entityId']}=topic.".Topic::$mapping['id']." "
            ."AND rating.{$ratingStats->columns['tag']}='plus' "
            ."AND rating.{$ratingStats->columns['type']}='count'";

        $where = " WHERE 1=1 ";
        if(!empty($ids)){
            $len = count($ids);
            $count = 0;
            $where .= "AND user.".User::$mapping['id']." IN (";
            foreach($ids as $id){
                $where.=$id;
                if($count++<$len-1){
                    $where.=",";
                }
                else{
                    $where.=') ';
                }
            }
        }


        if($endTime!=null){
            $where .="AND topic.".Topic::$mapping['createdTime']."<'{$endTime}' ";
        }

        $sql.=$where;

        $sql.="ORDER BY topic.".Topic::$mapping['id']." DESC ";

        if($limit!=0){
            $sql.="LIMIT ".$limit." ";
        }

        return Data::db_query($sql);
    }

    public function delete($assignment = array()){
        $counter = new Counter();
        $counter = $counter->loadCounter($this->id,self::$entityType);
        if($counter!=null)
            $counter->delete();
        $this->deleteWithComment();
    }

    public function deleteWithComment($topicId=''){
        if($topicId!==''&&is_numeric($topicId)){
            $this->id = $topicId;
        }
        if (isset($this->id) && $this->id != '') {
            $comments = $this->getComments();
            foreach ($comments as $comment){
                $comment['root']->delete();
            }
            parent::delete();
        }
    }

    public static function getDayTopViewPosts($start=0,$limit=0){
        $topics = new Topic();
        $user = new User();
        $group = new Group();
        $counter = new Counter();
        $ratingStats = new RatingStatistic();
        $entityType = Topic::$entityType;

        $sql = "SELECT "
            ."user.{$user->columns['id']},"
            ."user.{$user->columns['name']},"
            ."user.{$user->columns['picture']},"
            ."topic.{$topics->columns['id']},"
            ."topic.{$topics->columns['title']},"
            ."topic.{$topics->columns['content']},"
            ."topic.{$topics->columns['createdTime']},"
            ."topic.{$topics->columns['commentCount']},"
            ."groups.{$group->columns['id']},"
            ."groups.{$group->columns['name']},"
            ."counter.{$counter->columns['dayCount']},"
            ."rating.{$ratingStats->columns['value']} AS plusCount "
            ." FROM {$topics->table} AS topic "
            ."LEFT JOIN {$counter->table} AS counter ON counter.{$counter->columns['entityId']}=topic.{$topics->columns['id']} AND counter.{$counter->columns['entityTypeId']}={$entityType} "
            ."LEFT JOIN {$user->table} AS user on topic.{$topics->columns['userId']}=user.{$user->columns['id']} "
            ."LEFT JOIN {$group->table} AS groups on groups.{$group->columns['id']}=topic.{$topics->columns['groupId']} "
            ."LEFT JOIN {$ratingStats->table} AS rating on rating.{$ratingStats->columns['entityType']}={$entityType} "
            ."AND rating.{$ratingStats->columns['entityId']}=topic.{$topics->columns['id']} "
            ."AND rating.{$ratingStats->columns['tag']}='plus' "
            ."AND rating.{$ratingStats->columns['type']}='count'";

        $where = "WHERE 1=1 ";
//        $beginTime = date('Y-m-d: 00:00:00');

//        $where .=" AND topic.{$topics->columns['createdTime']}>'{$beginTime}' ";
        $where .=" AND counter.{$counter->columns['dayCount']} > 0 ";

        $sql.=$where;

        $sql.="ORDER BY counter.{$counter->columns['dayCount']} DESC ";

        if($start!=0||$limit!=0){
            $sql .= "LIMIT {$start},{$limit} ";
        }

        return Data::db_query($sql);
    }
}