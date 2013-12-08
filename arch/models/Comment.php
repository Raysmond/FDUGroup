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
    public static $relation = array(
        "user" => array("userId", "User", "id"),
        "topic" => array("topicId", "Topic", "id")
    );
}