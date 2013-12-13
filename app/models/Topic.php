<?php
/**
 * Topic model
 *
 * @author: Raysmond, Xiangyan Sun
 */
class Topic extends RModel
{
    public $group;
    public $user;
    public $comments = array();

    public $rating;
    public $counter;

    public $id, $groupId, $userId, $title, $createdTime, $content, $lastCommentTime, $commentCount;

    const ENTITY_TYPE = 1;

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
        "group" => array("Group", "[groupId] = [Group.id]"),
        "user" => array("User", "[userId] = [User.id]"),
        "rating" => array("RatingStatistic", "[id] = [RatingStatistic.entityId] AND [RatingStatistic.type]='count' AND [RatingStatistic.tag]='plus' AND [RatingStatistic.entityType] = 1"),
        "counter" => array("Counter","[id] = [Counter.entityId] AND [Counter.entityTypeId] = 1")
    );

    public function increaseCounter(){
        if(isset($this->id)&&$this->id!=''){
            $counter = new Counter();
            $counter->increaseCounter($this->id, self::ENTITY_TYPE);
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

    /**
     * Override delete method
     * Delete topic itself and all it's comments, ratings, and view counter
     */
    public function delete(){
        $tid = $this->id;

        // delete view counter
        $counter = Counter::find(["entityId",$tid,"entityTypeId",Topic::ENTITY_TYPE])->first();
        if($counter!=null)
            $counter->delete();

        // delete plus-rating data
        $plus = new RatingPlus(Topic::ENTITY_TYPE,$tid);
        $plus->delete();

        Comment::where("[topicId] = ?", $tid)->delete();

        parent::delete();
    }

    // TODO: use Model functions instead of SQL
    public function getUserFriendsTopics($uid,$limit=0,$endTime=null){
        $friends = Friend::find("uid",$uid)->all();

        $topics = new Topic();
        $ids = array();
        foreach($friends as $friend){
            $ids[] = $friend->fid;
        }
        $ids[] = $uid;

        $user = new User();
        $group = new Group();
        $ratingStats = new RatingStatistic();
        $entityType = Topic::ENTITY_TYPE;

        $prefix = Rays::app()->getDBPrefix();
        $sql = "SELECT "
            ."user.".User::$mapping['id'].","
            ."user.".User::$mapping['name'].","
            ."user.".User::$mapping['picture'].","
            ."topic.".Topic::$mapping['id'].","
            ."topic.".Topic::$mapping['title'].","
            ."topic.".Topic::$mapping['content'].","
            ."topic.".Topic::$mapping['createdTime'].","
            ."topic.".Topic::$mapping['commentCount'].","
            ."groups.".Group::$mapping['id'].","
            ."groups.".Group::$mapping['name'].","
            ."rating.{$ratingStats::$mapping['value']} AS plusCount"
            ." FROM ".$prefix.Topic::$table." AS topic "
            ."LEFT JOIN ".$prefix.User::$table." AS user on topic.".Topic::$mapping['userId']."=user.".User::$mapping['id']." "
            ."LEFT JOIN ".$prefix.Group::$table." AS groups on groups.{$group::$mapping['id']}=topic.".Topic::$mapping['groupId']." "
            ."LEFT JOIN {$prefix}{$ratingStats::$table} AS rating on rating.{$ratingStats::$mapping['entityType']}={$entityType} "
            ."AND rating.{$ratingStats::$mapping['entityId']}=topic.".Topic::$mapping['id']." "
            ."AND rating.{$ratingStats::$mapping['tag']}='plus' "
            ."AND rating.{$ratingStats::$mapping['type']}='count'";

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

    public static function getDayTopViewPosts($start = 0, $limit = 10)
    {
        Counter::checkAll(Topic::ENTITY_TYPE);
        $query = Topic::find()->join("user")->join("group")->join("rating")->join("counter");
        $query = $query->order("desc", "[Counter.dayCount]")->where("[Counter.dayCount]>0");
        $results = $query->range($start, $limit);
        return $results;
    }
}