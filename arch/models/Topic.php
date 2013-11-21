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

    public $id, $groupId, $userId, $title, $createdTime, $content, $lastCommentTime, $commentCount;

    public static $entityType = 1;

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

    public function increaseCounter(){
        if(isset($this->id)&&$this->id!=''){
            $counter = new Counter();
            $counter->increaseCounter($this->id,self::$entityType);
            return $counter;
        }
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

    public function adminFindAll($start,$pageSize,$order=array()){
        $user = new User();
        $group = new Group();
        $sql = "SELECT "
            ."topic.{$this->columns['id']} AS topic_id "
            .",topic.{$this->columns['userId']} AS user_id "
            .",topic.{$this->columns['groupId']} AS group_id "
            .",topic.{$this->columns['title']} AS topic_title "
            .",topic.{$this->columns['createdTime']} AS topic_created_time "
            .",topic.{$this->columns['commentCount']} AS topic_comment_count "
            .",user.{$user->columns['name']} AS user_name "
            .",user.{$user->columns['picture']} AS user_picture "
            .",groups.{$group->columns['name']} AS group_name "
            ."FROM {$this->table} AS topic "
            ."LEFT JOIN {$user->table} AS user ON user.{$user->columns['id']}=topic.{$this->columns['userId']} "
            ."LEFT JOIN {$group->table} AS groups ON groups.{$group->columns['id']}=topic.{$this->columns['groupId']} ";

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

    public function getActiveTopics($beginTime=null,$limit=0){
        $user = new User();
        $group = new Group();
        $sql = "SELECT "
            ."topic.{$this->columns['id']} AS topic_id "
            .",topic.{$this->columns['userId']} AS user_id "
            .",topic.{$this->columns['groupId']} AS group_id "
            .",topic.{$this->columns['title']} AS topic_title "
            .",topic.{$this->columns['content']} AS topic_content "
            .",topic.{$this->columns['createdTime']} AS topic_created_time "
            .",topic.{$this->columns['commentCount']} AS topic_comment_count "
            .",user.{$user->columns['picture']} AS user_picture "
            .",user.{$user->columns['name']} AS user_name "
            .",groups.{$group->columns['name']} AS group_name "
            ."FROM {$this->table} AS topic "
            ."LEFT JOIN {$user->table} AS user ON user.{$user->columns['id']}=topic.{$this->columns['userId']} "
            ."LEFT JOIN {$group->table} AS groups ON groups.{$group->columns['id']}=topic.{$this->columns['groupId']} "
            .($beginTime===null?"":"WHERE topic.{$this->columns['createdTime']}>'{$beginTime}' ")
            ."ORDER BY topic.{$this->columns['commentCount']} DESC ".($limit!=0?"LIMIT ".$limit:"");
        $result = Data::db_query($sql);
        return $result;
    }
}