<?php
// Comment

require_once("./arch.php");

class Comment extends Tree
{
    public $user, $topic;
    public $id, $pid, $topicId, $userId, $createdTime, $content;

    public function __construct()
    {
        $option = array(
            "key" => "id",
            "pkey" => "pid",
            "table" => "comment",
            "columns" => array(
                "id" => "com_id",
                "pid" => "com_pid",
                "topicId" => "top_id",
                "userId" => "u_id",
                "createdTime" => "com_created_time",
                "content" => "com_content"
            )
        );
        parent::init($option);
    }

    public function load($id = null)
    {
        parent::load($id);
        $this->user = new User();
        $this->user->id = $this->userId;
        $this->topic = new Topic();
        $this->topic->id = $this->topicId;
    }
}