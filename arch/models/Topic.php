<?php
/**
 * Class Topic
 * @author: Raysmond
 */
class Topic extends Data
{
    public $group;
    public $user;
    public $id, $groupId, $userId, $title, $createdTime, $content, $lastCommentTime, $memberCount;

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
        parent::load($id);
        $this->user = new User();
        $this->user->id = $this->userId;
        $this->group = new Group();
        $this->group->id = $this->groupId;
    }

}