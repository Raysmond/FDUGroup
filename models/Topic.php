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
        Counter::where("[entityId] = ? AND [entityTypeId] = ?",[$tid,Topic::ENTITY_TYPE])->delete();
        Rating::where("[entityId] = ? AND [entityType] = ?",[$tid,Topic::ENTITY_TYPE])->delete();
        RatingStatistic::where("[entityId] = ? AND [entityType] = ?",[$tid,Topic::ENTITY_TYPE])->delete();
        Comment::where("[topicId] = ?", $tid)->delete();

        parent::delete();
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