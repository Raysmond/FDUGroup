<?php
/**
 * Class Topic
 * @author: Raysmond
 */
class Topic extends Data
{
    public $group;
    public $user;
    public $comments = array();

    public $id, $groupId, $userId, $title, $createdTime, $content, $lastCommentTime, $memberCount, $commentCount;

    public function __construct()
    {
        $option = array(
            "key" => "id",
            "table" => "topic",
            "columns" => array(
                "id" => "top_id",
                "groupId" => "gro_id",
                "userId" => "u_id",
                "title" => "top_title",
                "createdTime" => "top_created_time",
                "content" => "top_content",
                "lastCommentTime" => "top_last_comment_time",
                "commentCount" => "top_comment_count"
            )
        );

        parent::init($option);
    }

    public function load($id = null)
    {
        $result = parent::load($id);
        if($result===null) return null;
        $this->user = new User();
        $this->user->id = $this->userId;
        $this->group = new Group();
        $this->group->id = $this->groupId;
        return $this;
    }

    public function getComments()
    {
        $comment = new Comment();
        $comment->topicId = $this->id;
        $this->comments = $comment->find(0, 0, [], [], ['pid' => '0']);
        $result = [];
        foreach ($this->comments as $c) {
            $result[] = ['root' => $c, 'reply' => $c->children()];
        }
        return $result;
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

        $sql = "SELECT * FROM {$topics->table} AS topic "
            ."LEFT JOIN {$user->table} AS user on topic.{$topics->columns['userId']}=user.{$user->columns['id']} "
            ."LEFT JOIN {$group->table} AS groups on groups.{$group->columns['id']}=topic.{$topics->columns['groupId']} ";

        $where = " WHERE 1=1 ";
        if(!empty($ids)){
            $len = count($ids);
            $count = 0;
            $where .= "AND user.{$user->columns['id']} in (";
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
            $where .="AND topic.{$topics->columns['createdTime']}<'{$endTime}' ";
        }

        $sql.=$where;

        $sql.="ORDER BY topic.{$topics->columns['id']} DESC ";

        if($limit!=0){
            $sql.="LIMIT ".$limit." ";
        }
       // echo $sql;

        return self::db_query($sql);
    }
}