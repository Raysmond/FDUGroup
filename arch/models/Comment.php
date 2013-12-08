<?php
/**
 * Comment data model
 * @author: Raysmond, Xiangyan Sun
 */

class Comment extends Tree
{
    public $user, $topic;
    public $id, $pid, $topicId, $userId, $createdTime, $content;

    public static $primary_key = "id";
    public static $parent_key = "pid";
    public static $table = "comment";
    public static $mapping = array(
        "id" => "com_id",
        "pid" => "com_pid",
        "topicId" => "top_id",
        "userId" => "u_id",
        "createdTime" => "com_created_time",
        "content" => "com_content"
    );

    public function load($id = null)
    {
        $result = parent::load($id);
        if($result===null) return null;
        $this->user = new User();
        $this->user->id = $this->userId;
        $this->topic = new Topic();
        $this->topic->id = $this->topicId;
        return $this;
    }

    public function findAll($start,$pageSize,$order=array()){
        $user = new User();
        $topic = new Topic();
        $sql = "SELECT "
            ."comment.{$this->columns['id']} AS comment_id "
            .",comment.{$this->columns['pid']} AS comment_pid "
            .",comment.{$this->columns['topicId']} AS comment_topic_id "
            .",comment.{$this->columns['userId']} AS comment_user_id "
            .",comment.{$this->columns['createdTime']} AS comment_created_time "
            .",comment.{$this->columns['content']} AS comment_content "
            .",user.{$user->columns['name']} AS user_name "
            .",topic.{$topic->columns['title']} AS topic_title "
            ."FROM {$this->table} AS comment "
            ."LEFT JOIN {$user->table} AS user ON user.{$user->columns['id']}=comment.{$this->columns['userId']} "
            ."LEFT JOIN {$topic->table} AS topic ON topic.{$topic->columns['id']}=comment.{$this->columns['topicId']} "
            ."";

        if(!empty($order)){
            if(isset($order['key'])&&isset($this->columns[$order['key']])){
                if(isset($order['order'])&&strcasecmp($order['order'],'desc')==0){
                    $sql.=" ORDER BY {$this->columns[$order['key']]} DESC ";
                }
                else{
                    $sql.=" ORDER BY {$this->columns[$order['key']]} ASC ";
                }
            }
        }
        $sql.="LIMIT {$start},{$pageSize}";

        $result = self::db_query($sql);
        return $result;
    }


}